<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectPhoto extends Model
{
    public $timestamps = false;
    protected $table = 'project_image';
    protected $fillable = ['url','project_id'];
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'images', 'id', 'postid');
    }
    public function category(): belongsToMany
    {
        return $this->belongsToMany(Categories::class, 'posts', 'id', 'category_id');
    }
    public function label(): belongsToMany
    {
        return $this->belongsToMany(Labels::class, 'post_label', 'post_id', 'label_id')
            ->withPivot('label_id')
            ->select('label.id', 'label.name', 'label.plug');
    }
}
