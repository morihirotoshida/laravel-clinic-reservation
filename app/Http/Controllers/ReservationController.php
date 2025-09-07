<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon; // Carbonライブラリを使えるように追加

class ReservationController extends Controller
{
    /**
     * トップページ（予約空き状況一覧）を表示します。
     */
    public function index()
    {
        // 現在時刻以降で、まだ予約されていない時間枠を取得します
        $timeSlots = TimeSlot::where('date', '>=', now()->toDateString())
            ->where('is_booked', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            // コレクションをフィルタリングして、今日の日付の場合は過去の時間を除外します
            ->filter(function ($slot) {
                return Carbon::parse($slot->date . ' ' . $slot->start_time, 'Asia/Tokyo')->isFuture();
            });

        // 取得した時間枠データをビューに渡して表示します
        return view('welcome', compact('timeSlots'));
    }

    public function create(TimeSlot $time_slot)
    {
        return view('reservations.create', compact('time_slot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'patient_name' => 'required|string|max:255',
            'patient_tel'  => 'required|string|max:255',
            'symptoms'     => 'nullable|string',
        ]);

        // データベース処理を安全に行うための「トランザクション」を開始
        DB::beginTransaction();
        try {
            // 他の人が同時に予約できないように、時間枠のレコードをロック
            $timeSlot = TimeSlot::where('id', $request->time_slot_id)->lockForUpdate()->first();

            // 念のため、データベースでもう一度予約済みでないかチェック
            if ($timeSlot->is_booked) {
                DB::rollBack(); // 処理を中断
                return redirect()->back()->withErrors(['error' => '申し訳ありません。入力中に他の方が予約を完了したため、この時間枠はご利用いただけません。']);
            }

            // 時間枠を「予約済み」に更新
            $timeSlot->update(['is_booked' => true]);

            // 予約情報を作成
            Reservation::create([
                'time_slot_id' => $request->time_slot_id,
                'patient_name' => $request->patient_name,
                'patient_tel'  => $request->patient_tel,
                'symptoms'     => $request->symptoms,
            ]);

            // 全ての処理が成功したら、変更をデータベースに確定
            DB::commit();

        } catch (Exception $e) {
            // エラーが発生した場合は、全ての変更を元に戻す
            DB::rollBack();
            // サーバーのログにエラー内容を記録
            Log::error('予約処理中にエラーが発生しました: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'サーバーでエラーが発生しました。お手数ですが、もう一度やり直してください。']);
        }

        // 成功したら完了ページへ移動
        return redirect()->route('reservations.thanks');
    }

    public function thanks()
    {
        return view('reservations.thanks');
    }
}

