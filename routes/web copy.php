<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TimeSlotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ユーザー（患者）側のルート
// トップページ（予約カレンダー）
Route::get('/', [ReservationController::class, 'index'])->name('home');
// 予約入力フォームページ
Route::get('/reservations/create/{time_slot}', [ReservationController::class, 'create'])->name('reservations.create');
// 予約処理
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
// 予約完了ページ
Route::get('/thanks', function () {
    return view('reservations.thanks');
})->name('thanks');


// 管理者側のルート
// 'admin' というプレフィックスをつけ、認証ミドルウェア(auth)を適用
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 管理者ダッシュボード（予約一覧）
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // 時間枠の管理（一覧表示、登録、削除）
    Route::resource('timeslots', TimeSlotController::class)->only(['index', 'store', 'destroy']);
});


// Laravel Breezeなどの認証機能のルート（ログインなど）
// この行は breeze:install を実行すると自動で追加されます
require __DIR__.'/auth.php';

