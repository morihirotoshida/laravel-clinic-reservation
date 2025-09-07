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
        // 予約情報を格納するテーブル
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // time_slotsテーブルのidと連携する外部キー
            $table->foreignId('time_slot_id')->constrained()->onDelete('cascade');
            $table->string('patient_name'); // 患者名
            $table->string('patient_tel'); // 患者の電話番号
            $table->text('symptoms')->nullable(); // 症状など（任意）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
