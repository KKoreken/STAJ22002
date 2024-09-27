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

class Work extends Model

{
    use HasApiTokens, HasFactory, Notifiable;
    use HasTickets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    public $timestamps = false;
    public function proje()
    {
        return $this->belongsTo(Proje::class, 'proje_id');
    }
    public function dosya()
    {
        return $this->hasMany(Files::class, 'work_id');
    }
    // Work'in IsSahipligi ile ilişkisi
    public function isSahipligi()
    {
        return $this->hasMany(IsSahipligi::class, 'work_id');
    }

    public function sayi()
    {
        return $this->belongsTo(IsSahipligi::class, 'issahipligi_id');
    }
    public function users()
    {
        return $this->hasManyThrough(User::class, IsSahipligi::class, 'work_id', 'id', 'id', 'user_id');
    }
}
