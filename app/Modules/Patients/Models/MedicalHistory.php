<?php

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'condition_name',
        'status',
        'notes',
    ];

    protected $casts = [
        'patient_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Allowed Statuses
    |--------------------------------------------------------------------------
    */
    public const ACTIVE = 'active';
    public const RESOLVED = 'resolved';
    public const CHRONIC = 'chronic';

    public static function allowedStatuses(): array
    {
        return [
            self::ACTIVE,
            self::RESOLVED,
            self::CHRONIC,
        ];
    }

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