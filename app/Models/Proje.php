<?php

namespace App\Models;

use App\Models\ProjectCategories;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proje extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    public function works()
    {
        return $this->hasMany(Work::class, 'proje_id');
    }
    public function dosya()
    {
        return $this->hasMany(Files::class, 'project_id');
    }
}
