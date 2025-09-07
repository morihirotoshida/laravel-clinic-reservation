<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * フォームからのデータで、どのカラムを更新・作成して良いかを定義します。
     * この設定がないと、セキュリティのためにデータが保存されません。
     * @var array
     */
    protected $fillable = [
        'time_slot_id',
        'patient_name',
        'patient_tel',
        'symptoms',
    ];

    /**
     * この予約がどの時間枠に紐づいているかを取得するための関係を定義します。
     */
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}