<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class User extends Authenticatable implements BannableContract
{
    use HasApiTokens, HasFactory, Notifiable, Bannable;
    use SoftDeletes;
    protected $guarded = false;
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // Связь один ко многим к модели Order (заказы):
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function offer() {
        return $this->hasMany(OfferForDelivery::class);
    }
    // Защита маршрута от забаненных людей:
    public function shouldApplyBannedAtScope()
    {
        return true;
    }
    // Связь один ко многим к модели Delivery (доставки):
    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }
}
