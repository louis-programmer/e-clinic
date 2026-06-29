<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'clinic_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

/*
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }
*/


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function hasRole($roleName)
    {
        return $this->roles()
            ->where('name', $roleName)
            ->exists();
    }

public function hasAnyRole(...$roles)
{
    // Allow passing an array
    if (count($roles) === 1 && is_array($roles[0])) {
        $roles = $roles[0];
    }

    return $this->roles()
        ->whereIn('name', $roles)
        ->exists();
}


public function canAccess(string $permission): bool
{
    return $this->hasAnyRole(config("roles.$permission", []));
}



}
