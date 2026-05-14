<?php
use App\Modules\Patients\Models\Appointment;

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
            'appointment_date' => $data['appointment_date'],
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
        $this->lockCheck($appointment);

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
        $this->lockCheck($appointment);

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
        $this->lockCheck($appointment);

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
        $this->lockCheck($appointment);

        $appointment->update([
            'appointment_date' => $date,
            'status'           => AppointmentStatus::RESCHEDULED,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Lock Check
    |--------------------------------------------------------------------------
    */
    private function lockCheck(Appointment $appointment): void
    {
        if (in_array($appointment->status, AppointmentStatus::final())) {
            abort(403, 'Appointment already finalized.');
        }
    }
}