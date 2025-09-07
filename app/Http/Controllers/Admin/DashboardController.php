<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * 管理者ダッシュボード（予約一覧）を表示します。
     */
    public function index()
    {
        // 予約情報を時間枠の日時が新しい順に取得します。
        // with()を使うことで、N+1問題を回避し、パフォーマンスが向上します。
        $reservations = Reservation::with('timeSlot')
            ->join('time_slots', 'reservations.time_slot_id', '=', 'time_slots.id')
            ->orderBy('time_slots.date', 'desc')
            ->orderBy('time_slots.start_time', 'desc')
            ->select('reservations.*') // reservationsテーブルの全カラムを選択
            ->paginate(10);

        return view('admin.dashboard', compact('reservations'));
    }

    /**
     * 指定された予約を削除します。
     */
    public function destroy(Reservation $reservation)
    {
        // 関連する時間枠を取得
        $timeSlot = $reservation->timeSlot;

        // 予約を削除
        $reservation->delete();

        // 関連する時間枠が存在すれば、その予約ステータスを「空き」に戻す
        if ($timeSlot) {
            $timeSlot->update(['is_booked' => false]);
        }

        // 削除が完了したら、ダッシュボードにリダイレクトし、成功メッセージを表示
        return redirect()->route('admin.dashboard')->with('success', '予約を削除しました。');
    }
}

?>