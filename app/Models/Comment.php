<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'ip_address',
        'status',
        'user_id',
        'post_id',
    ];

    ################################### START RELATIONS
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function comment(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    ################################### END RELATIONS
}
