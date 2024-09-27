<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Photo;

class PostLabel extends Model
{
    public $timestamps = false;
    protected $table = 'post_label';
    protected $fillable = ['post_id','label_id'];
}
