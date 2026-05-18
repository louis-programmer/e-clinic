<?php

namespace App\Modules\Patients\Models;


use Illuminate\Database\Eloquent\Model;
use App\Modules\Patients\Models\Patient;
use App\Modules\Patients\Models\Procedure;

class ProgressNote extends Model
{
    protected $fillable = [
        'patient_id',
        'procedure_id',
        'remarks',
        'created_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}