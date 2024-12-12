<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'small_desc'
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
                'source' => 'name'
            ]
        ];
    }

    ################################### START SCOPE
    public function scopeActive(Builder $query)
    {
        return $query->whereStatus(1);
    }
    ################################### END SCOPE

    ################################### START RELATIONS
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    ################################### END RELATIONS

    ################################### START GENERAL FUNCTIONS
    public function status()
    {
        return $this->status  == 1 ? 'Active' : 'Not Active';
    }
    ################################### END GENERAL FUNCTIONS
}
