<?php
#update May 14

namespace App\Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_date',
        'purpose',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

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
}