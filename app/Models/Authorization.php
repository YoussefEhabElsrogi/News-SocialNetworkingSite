<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authorization extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'permessions'];

    protected $casts = [
        'permessions' => 'array',
    ];

    ################################### START RELATIONS
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
    ################################### END RELATIONS
}
