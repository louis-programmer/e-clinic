<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use App\Models\Appointment;
use App\Modules\Patients\Models\Appointment;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,staff,doctor');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Appointment
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, $patientId)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
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

    /*
    |--------------------------------------------------------------------------
    | Complete Appointment
    |--------------------------------------------------------------------------
    */
    public function complete(Appointment $appointment)
    {
        $this->updateStatus($appointment, 'completed');

        return back()->with('success', 'Appointment marked as completed.');
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel Appointment
    |--------------------------------------------------------------------------
    */
    public function cancel(Appointment $appointment)
    {
        $this->updateStatus($appointment, 'cancelled');

        return back()->with('success', 'Appointment cancelled.');
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule Appointment
    |--------------------------------------------------------------------------
    */
    public function reschedule(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
        ]);

        $appointment->update([
            'appointment_date' => $validated['appointment_date'],
            'status'           => 'rescheduled',
        ]);

        return back()->with('success', 'Appointment rescheduled.');
    }

    /*
    |--------------------------------------------------------------------------
    | Upcoming Appointments
    |--------------------------------------------------------------------------
    */
    public function upcoming()
    {
        return Appointment::whereIn('status', ['scheduled', 'rescheduled'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: Update Status
    |--------------------------------------------------------------------------
    */
    private function updateStatus(Appointment $appointment, string $status): void
    {
        $appointment->update([
            'status' => $status,
        ]);
    }


    public function noShow(Appointment $appointment)
        {
            $appointment->status = 'no-show';
            $appointment->save();

            return back()->with('success', 'Appointment marked as no-show.');
        }



    public function destroy(Appointment $appointment)
    {
        $user = auth()->user();

        // ROLE CHECK (adjust to your config system)
        if (! $user->hasAnyRole(...config('roles.patient_manage'))) {
            abort(403, 'Unauthorized action.');
        }

        // Optional safety rule: prevent deleting completed records
        if ($appointment->status === 'completed') {
            return back()->with('error', 'Completed appointments cannot be deleted.');
        }

        $appointment->delete();

        return back()->with('success', 'Appointment deleted successfully.');
    }



}