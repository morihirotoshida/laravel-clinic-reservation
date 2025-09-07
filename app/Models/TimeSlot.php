<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Carbonライブラリを使えるように追加

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'is_booked',
    ];

    /**
     * 時間枠に対する予約情報を取得するリレーション
     */
    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }

    /**
     * 日付と時刻を結合したCarbonインスタンスを返すアクセサを追加
     * これにより、ビューで $time_slot->slot_datetime のようにアクセスできます。
     */
    public function getSlotDatetimeAttribute()
    {
        return Carbon::parse($this->date . ' ' . $this->start_time, 'Asia/Tokyo');
    }
}

