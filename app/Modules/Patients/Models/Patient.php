<?php

namespace App\Modules\Patients\Models;
use App\Models\Encounter;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'clinic_id',
        'patient_code',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'gender',
        'contact_number',
        'address',
    ];


    protected $casts = [
        'birthdate' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
        
    }

    public function getAgeAttribute()
    {
        return $this->birthdate
            ? $this->birthdate->age
            : null;
    }

    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }



}