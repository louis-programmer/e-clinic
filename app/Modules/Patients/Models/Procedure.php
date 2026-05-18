<?php

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category',
    ];
}