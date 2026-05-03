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
        'password',
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

//instead of repeating everywhere:@if(auth()->check() && auth()->user()->hasRole('admin'))
    public function hasAnyRole(...$roles)
    {
        return $this->roles()
            ->whereIn('name', $roles)
            ->exists();
    }

}
