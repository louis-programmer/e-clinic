<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;




class License extends Model
{
    protected $fillable = [

        'activation_code',

        'clinic_id',

        'plan',

        'expires_at',

        'grace_days',

        'activated_at',

    ];

    protected $casts = [

        'expires_at' => 'date',

        'activated_at' => 'datetime',

    ];
}