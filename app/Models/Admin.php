<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role_id',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function hasAccess($config_permession)
    {
        $authorizations = $this->authorization; // get admin role

        if (!$authorizations) {
            return false;
        }

        foreach ($authorizations->permessions as $permission) {
            if ($config_permession == $permission ?? false) {
                return true;
            }
        }
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'admins.' . $this->id;
    }

    ################################### START RELATIONS
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function authorization(): BelongsTo
    {
        return $this->belongsTo(Authorization::class, 'role_id');
    }
    ################################### END RELATIONS
}
