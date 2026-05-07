<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('role:admin,staff,doctor');
    }

    public function store(Request $request, $patientId)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'purpose' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['patient_id'] = $patientId;

        Appointment::create($validated);

        return back()->with('success', 'Appointment created');
    }


    
}