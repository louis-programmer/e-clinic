<?php

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DentalChartRecord extends Model
{
 protected $fillable = [
        'patient_id',
        'tooth_number',
        'surface',
        'remark',
        'condition',
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