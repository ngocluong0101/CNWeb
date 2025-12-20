<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    // Các cột có thể gán dữ liệu hàng loạt
    protected $fillable = [
        'computer_id',
        'reported_by',
        'reported_date',
        'description',
        'urgency',
        'status'
    ];

    // Một vấn đề thuộc về một máy tính
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
