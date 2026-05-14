<?php
#May 14 upadate

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppointmentService;
use App\Modules\Patients\Models\Appointment;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;

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
        if ($appointment->status === 'completed') {
            return back()->with('error', 'Completed appointments cannot be deleted.');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }
}