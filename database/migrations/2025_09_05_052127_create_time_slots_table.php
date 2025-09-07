<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 予約可能な時間枠を管理するテーブル
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // 予約日
            $table->time('start_time'); // 開始時刻
            $table->boolean('is_booked')->default(false); // 予約済みフラグ
            $table->timestamps();

            // 同じ日時のスロットが重複して登録されないようにユニーク制約を設定
            $table->unique(['date', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_slots');
    }
};
