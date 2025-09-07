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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ユーザー（患者）側のルート
Route::get('/', [ReservationController::class, 'index'])->name('welcome'); // トップページの名前を'welcome'に変更
// ↓↓↓ パラメータ名を {time_slot_id} から {time_slot} に変更しました ↓↓↓
Route::get('/reservations/create/{time_slot}', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/thanks', [ReservationController::class, 'thanks'])->name('reservations.thanks');


// 管理者側のルート
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('timeslots', TimeSlotController::class)->only(['index', 'store', 'destroy']);
    Route::delete('/reservations/{reservation}', [DashboardController::class, 'destroy'])->name('reservations.destroy');
});


require __DIR__.'/auth.php';

