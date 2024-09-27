<?php

namespace App\Models;

use App\Models\ProjectCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Label;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public $timestamps = false;
    protected $table = 'projeler';
    protected $fillable = ['baslik','icerik','cover','category_id','category_id','url'];
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'images', 'id', 'photo_id');
    }
    public function category(): belongsToMany
    {
        return $this->belongsToMany(ProjectCategories::class, 'posts', 'id', 'category_id');
    }
    public function lang():HasMany{
        return $this->hasMany(ProjectLang::class, 'id', 'lang_id');
    }
    public function label(): belongsToMany
    {
        return $this->belongsToMany(Labels::class, 'post_label', 'post_id', 'label_id')
            ->withPivot('label_id')
            ->select('label.id', 'label.name', 'label.plug');
    }
}
