<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'post_id',
    ];
    ################################### START RELATIONS
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    ################################### END RELATIONS
}
