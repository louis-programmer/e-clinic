<?php
# May 15 update (safe upgrade, backward compatible)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppointmentService;
use App\Modules\Patients\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Modules\Patients\Models\Patient;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

        public function __construct(AppointmentService $appointmentService)
        {
            $this->appointmentService = $appointmentService;

            $this->middleware('auth');

            $this->middleware(
                'role:' . implode(',', config('roles.appointments'))
            )->only([
                'store',
                'complete',
                'cancel',
                'reschedule',
                'noShow',
            ]);

            $this->middleware(
                'role:' . implode(',', config('roles.patient_manage'))
            )->only([
                'destroy',
            ]);
        }

    /*
    |--------------------------------------------------------------------------
    | Store Appointment
    |--------------------------------------------------------------------------
    */

public function store(Request $request, $patientId)
{
    $patient = Patient::findOrFail($patientId);

    $this->authorize('update', $patient);

    $validated = $request->validate([
        'appointment_date' => 'required|date|after_or_equal:now',
        'purpose' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ]);

    $this->appointmentService->create($validated, $patientId);

    return back()->with('success', 'Appointment created successfully.');
}

    /*
    |--------------------------------------------------------------------------
    | Complete Appointment
    |--------------------------------------------------------------------------
    */
    public function complete(Appointment $appointment)
    {
        $this->authorize('update', $appointment->patient); //secure
        $this->appointmentService->complete($appointment);

        return back()->with('success', 'Appointment marked as completed.');
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule Appointment
    |--------------------------------------------------------------------------
    */
    public function reschedule(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment->patient); //secure
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:now',
        ]);

        $this->appointmentService->reschedule(
            $appointment,
            $validated['appointment_date']
        );

        return back()->with('success', 'Appointment rescheduled.');
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Appointment
    |--------------------------------------------------------------------------
    */
    public function cancel(Appointment $appointment)
    {
        $this->authorize('update', $appointment->patient); // secure
        $this->appointmentService->cancel($appointment);

        return back()->with('success', 'Appointment cancelled.');
    }

    /*
    |--------------------------------------------------------------------------
    | No Show
    |--------------------------------------------------------------------------
    */
    public function noShow(Appointment $appointment)
    {
        $this->authorize('update', $appointment->patient); // secure
        $this->appointmentService->noShow($appointment);

        return back()->with('success', 'Appointment marked as no_show.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Appointment
    |--------------------------------------------------------------------------
    */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('update', $appointment->patient);// secure
        // Use enum instead of raw string (IMPORTANT FIX)
        if ($appointment->status === AppointmentStatus::COMPLETED) {
            return back()->with('error', 'Completed appointments cannot be deleted.');
        }

        // Optional extra safety: prevent deleting final states
        if (in_array($appointment->status, AppointmentStatus::final(), true)) {
            return back()->with('error', 'Finalized appointments cannot be deleted.');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }
}