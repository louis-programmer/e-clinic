<?php

namespace App\Modules\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Patients\Models\Patient;

class PatientForm extends Model
{
    protected $fillable = [
        'patient_id',
        'title',
        'category',
        'remarks',
        'file_path',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}