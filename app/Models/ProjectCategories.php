<?php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectCategories extends Model
{
    use HasFactory;
    use HasVisibility;
    protected $table = 'project_category';
    protected $fillable = ['name', 'slug', 'is_visible'];

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
        return $this->hasMany(Project::class, 'category_id', 'id');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */

}
