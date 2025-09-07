<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * 予約可能な時間枠一覧を表示 (トップページ)
     */
    public function index()
    {
        // 今日以降の、まだ予約されていない時間枠を取得
        $timeSlots = TimeSlot::where('date', '>=', Carbon::today())
            ->where('is_booked', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('welcome', compact('timeSlots'));
    }

    /**
     * 予約フォームを表示
     */
    public function create(TimeSlot $time_slot)
    {
        // 既に予約済みの場合はトップページに戻す
        if ($time_slot->is_booked) {
            return redirect()->route('home')->with('error', 'この時間枠は既に予約されています。');
        }
        return view('reservations.create', compact('time_slot'));
    }

    /**
     * 予約処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'patient_name' => 'required|string|max:255',
            'patient_tel' => 'required|string|max:20',
            'symptoms' => 'nullable|string',
        ]);

        try {
            // トランザクションを開始
            DB::transaction(function () use ($request) {
                // 予約対象の時間枠を取得し、悲観的ロックをかける
                $timeSlot = TimeSlot::lockForUpdate()->find($request->time_slot_id);

                // 二重予約チェック
                if ($timeSlot->is_booked) {
                    // 既に予約されている場合は例外を投げてロールバックさせる
                    throw new \Exception('This time slot has already been booked.');
                }

                // 予約情報を保存
                Reservation::create($request->all());

                // 時間枠を「予約済み」に更新
                $timeSlot->is_booked = true;
                $timeSlot->save();
            });
        } catch (\Exception $e) {
            // 予約が競合した場合はエラーメッセージ付きでフォームに戻す
            return redirect()->route('reservations.create', ['time_slot' => $request->time_slot_id])
                             ->with('error', '申し訳ありません。タッチの差で別の方が予約を完了しました。別の時間枠を選択してください。');
        }

        return redirect()->route('thanks');
    }
}

