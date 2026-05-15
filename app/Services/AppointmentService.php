<?php

namespace App\Services;

use App\Modules\Patients\Models\Appointment;
use App\Enums\AppointmentStatus;
use Carbon\Carbon;

class AppointmentService
{
    /*
    |--------------------------------------------------------------------------
    | Create Appointment
    |--------------------------------------------------------------------------
    */
    public function create(array $data, int $patientId): Appointment
    {
        return Appointment::create([
            'patient_id'       => $patientId,
            'appointment_date' => Carbon::parse($data['appointment_date']),
            'purpose'          => $data['purpose'] ?? null,
            'notes'            => $data['notes'] ?? null,
            'status'           => AppointmentStatus::SCHEDULED,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Complete Appointment
    |--------------------------------------------------------------------------
    */
    public function complete(Appointment $appointment): void
    {
        $this->transition($appointment, AppointmentStatus::COMPLETED);

        $appointment->update([
            'status' => AppointmentStatus::COMPLETED,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Appointment
    |--------------------------------------------------------------------------
    */
    public function cancel(Appointment $appointment): void
    {
        $this->transition($appointment, AppointmentStatus::CANCELLED);

        $appointment->update([
            'status' => AppointmentStatus::CANCELLED,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | No Show
    |--------------------------------------------------------------------------
    */
    public function noShow(Appointment $appointment): void
    {
        $this->transition($appointment, AppointmentStatus::NO_SHOW);

        $appointment->update([
            'status' => AppointmentStatus::NO_SHOW,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule
    |--------------------------------------------------------------------------
    */
    public function reschedule(Appointment $appointment, string $date): void
    {
        $this->transition($appointment, AppointmentStatus::RESCHEDULED);

        $appointment->update([
            'appointment_date' => Carbon::parse($date),
            'status'           => AppointmentStatus::RESCHEDULED,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Transition Guard (IMPROVED LOCK SYSTEM)
    |--------------------------------------------------------------------------
    */
    private function transition(Appointment $appointment, string $newStatus): void
    {
        // 1. Block invalid current state
        if (in_array($appointment->status, AppointmentStatus::final(), true)) {
            abort(403, 'Appointment already finalized.');
        }

        // 2. Validate status itself
        if (!AppointmentStatus::isValid($newStatus)) {
            abort(400, 'Invalid appointment status.');
        }

        // 3. Enforce transition rules
        if (!AppointmentStatus::canTransition($appointment->status, $newStatus)) {
            abort(403, "Invalid status transition: {$appointment->status} → {$newStatus}");
        }
    }
}