<?php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categories extends Model
{
    use HasFactory;
    use HasVisibility;
    protected $table = 'category';
    protected $fillable = ['baslik','body','coverid','category_id','type'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get Tickets RelationShip
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */

}
