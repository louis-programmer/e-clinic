<?php
# update May 15 (safe upgrade, backward compatible)

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;
use App\Modules\Patients\Models\Patient;

class Appointment extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'patient_id',
        'appointment_date',
        'purpose',
        'status',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Boot (SAFE DATA PROTECTION)
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Prevent invalid statuses from being saved
        static::saving(function ($model) {
            if (!AppointmentStatus::isValid($model->status)) {
                throw new \InvalidArgumentException(
                    "Invalid appointment status: {$model->status}"
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', AppointmentStatus::active());
    }

    public function scopeFinal($query)
    {
        return $query->whereIn('status', AppointmentStatus::final());
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', AppointmentStatus::SCHEDULED);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return AppointmentStatus::label($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return AppointmentStatus::color($this->status);
    }

    /*
    |--------------------------------------------------------------------------
    | Optional Safety Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Check if current status is valid (safe debug helper)
     */
    public function getIsValidStatusAttribute(): bool
    {
        return AppointmentStatus::isValid($this->status);
    }

    /**
     * Check if appointment is still editable
     */
    public function getIsEditableAttribute(): bool
    {
        return in_array($this->status, AppointmentStatus::active(), true);
    }
}