<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    // Обратная связь к модели User:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Обратная связь к модели Order:
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
