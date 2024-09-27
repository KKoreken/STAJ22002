<?php

namespace App\Models;

use Coderflex\LaravelTicket\Concerns\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectLang extends Model
{
    use HasFactory;
    use HasVisibility;
    protected $table = 'project_lang';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get Tickets RelationShip
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_lang', 'lang_id', 'id');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
}
