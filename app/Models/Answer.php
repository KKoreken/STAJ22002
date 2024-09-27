<?php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Answer extends Model
{
    use HasFactory;
    use HasVisibility;

    protected $guarded = [];

    public function form()
    {
        return $this->hasOne(Form::class,'id','form_id');
    }

     public function soru()
    {
        return $this->hasOne(Soru::class,'id','soru_id');
    }

}
