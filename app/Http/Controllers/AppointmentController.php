<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Patients\Models\Appointment;
use App\Enums\AppointmentStatus;


class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff,doctor')
            ->only([
                'store',
                'complete',
                'cancel',
                'reschedule',
                'noShow'
            ]);

        $this->middleware('role:admin')
            ->only([
                'destroy'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Appointment
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, $patientId)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:now',
            'purpose'          => 'nullable|string|max:255',
            'notes'            => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id'       => $patientId,
            'appointment_date' => $validated['appointment_date'],
            'purpose'          => $validated['purpose'] ?? null,
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'scheduled',
        ]);

        return back()->with('success', 'Appointment created successfully.');
    }

    public function complete(Appointment $appointment)
    {
        $this->lockCheck($appointment);

        $appointment->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Appointment marked as completed.');
    }


        public function reschedule(Request $request, Appointment $appointment)
        {
            $this->lockCheck($appointment);

            $validated = $request->validate([
                'appointment_date' => 'required|date|after_or_equal:now',
            ]);

            $appointment->update([
                'appointment_date' => $validated['appointment_date'],
                'status' => 'rescheduled',
            ]);

            return back()->with('success', 'Appointment rescheduled.');
        }




    /*
    |--------------------------------------------------------------------------
    | Cancel Appointment (FIXED MISSING METHOD)
    |--------------------------------------------------------------------------
    */
    public function cancel(Appointment $appointment)
    {
        $this->lockCheck($appointment);

        $appointment->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Appointment cancelled.');
    }

    /*
    |--------------------------------------------------------------------------
    | No Show (STANDARDIZED)
    |--------------------------------------------------------------------------
    */
    public function noShow(Appointment $appointment)
    {
        $this->lockCheck($appointment);

        $appointment->update([
            'status' => 'no_show'
        ]);

        return back()->with('success', 'Appointment marked as no_show.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Appointment (ROLE HANDLED BY MIDDLEWARE)
    |--------------------------------------------------------------------------
    */
    public function destroy(Appointment $appointment)
    {
        if ($appointment->status === 'completed') {
            return back()->with('error', 'Completed appointments cannot be deleted.');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: Lock Check
    |--------------------------------------------------------------------------
    */
    private function lockCheck(Appointment $appointment)
    {

            if (in_array($appointment->status, AppointmentStatus::final())) {
                abort(403, 'Appointment already finalized.');
            }
    }


}