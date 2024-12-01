<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,  Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'comment_able',
        'status',
        'user_id',
        'small_desc',
        'admin_id',
        'category_id',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    ################################### START RELATIONS
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
    ################################### END RELATIONS

    ################################### START SCOPE
    public function scopeActive(Builder $query)
    {
        $query->where('status', 1);
    }
    ################################### END SCOPE
}
