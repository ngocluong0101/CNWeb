<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    // Các cột có thể gán dữ liệu hàng loạt
    protected $fillable = [
        'computer_name',
        'model',
        'operating_system',
        'processor',
        'memory',
        'available'
    ];

    // Một máy tính có nhiều vấn đề (issues)
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
