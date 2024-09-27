<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Label;

class Blog extends Model
{
    public $timestamps = false;
    protected $table = 'posts';
    protected $fillable = ['baslik','body','coverid','category_id'];
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
