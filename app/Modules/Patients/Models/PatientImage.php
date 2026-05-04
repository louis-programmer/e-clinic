<?php

namespace App\Modules\Patients\Models;
use App\Modules\Patients\Models\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientImage extends Model
{
    protected $fillable = [
        'patient_id',
        'file_path',
        'uploaded_by',
        'type',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }





}