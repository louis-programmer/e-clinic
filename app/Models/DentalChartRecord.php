<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Modules\Patients\Models\Patient;

class DentalChartRecord extends Model
{
protected $fillable = [
    'patient_id',
    'tooth_number',
    'surface',
    'condition',
    'remarks',
    'created_by',
];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}