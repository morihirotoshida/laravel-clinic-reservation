<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    /**
     * 時間枠管理ページと、登録済みの時間枠一覧を表示します。
     */
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15); // ページネーションを追加

        return view('admin.timeslots.index', compact('timeSlots'));
    }

    /**
     * 新しい時間枠をデータベースに保存します。
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
        ]);

        TimeSlot::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
        ]);

        return redirect()->route('admin.timeslots.index')->with('success', '時間枠を登録しました。');
    }

    /**
     * 指定された時間枠（と、それに紐づく予約）を削除します。
     */
    public function destroy(TimeSlot $timeslot)
    {
        // データベースの関連付け設定（カスケード削除）により、
        // 時間枠を削除すると、関連する予約情報も自動的に削除されます。
        $timeslot->delete();

        return redirect()->route('admin.timeslots.index')->with('success', '時間枠と関連する予約を削除しました。');
    }
}

//```
//
//### 解説
//
//* **`destroy`メソッドの追加**:
//    「時間枠管理」ページの削除ボタンが押されたときに、この`destroy`という処理が呼び出されます。
//* **自動的な予約削除**:
//    マイグレーションファイルの設定により、データベース側で「時間枠が削除されたら、関連する予約も自動で削除する」という連携が組まれています。そのため、プログラムは時間枠を削除するだけで、予約情報も一緒に綺麗に削除されます。
//
//このファイルを更新した後、ブラウザで「時間枠管理」ページを再読み込みし、予約済みの時間枠

