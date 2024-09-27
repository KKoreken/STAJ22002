<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\IsSahipligi;
use App\Models\Proje;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use App\Notifications\ResetPasswordNotification;

class Ekip extends Model

{
    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    public function uyesayilari()
    {
        return $this->hasMany(EkipUyeleri::class, 'ekip_id');
    }
    public function uyeler()
    {
        return $this->hasMany(EkipUyeleri::class, 'ekip_id');
    }
    public function departmanlar()
    {
        return $this->belongsTo(DepartmantEkipleri::class, 'ekip_id');
    }

}
