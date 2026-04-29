<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Patients\Models\Patient;

class Encounter extends Model
{
    protected $fillable = [
        'patient_id',
        'chief_complaint',
        'notes',
        'diagnosis',
        'encounter_date',
    ];

        protected $casts = [
        'encounter_date' => 'datetime',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}