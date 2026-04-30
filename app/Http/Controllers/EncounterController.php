<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encounter;
use App\Modules\Patients\Models\Patient;

class EncounterController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'chief_complaint' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string|max:255',
            'encounter_date' => 'nullable|date',
        ]);

        $validated['patient_id'] = $patient->id;

        Encounter::create($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Encounter added successfully');
    }

    public function edit($id)
    {
        $encounter = Encounter::findOrFail($id);

        return view('encounters.edit', compact('encounter'));
    }

    public function update(Request $request, $id)
    {
        $encounter = Encounter::findOrFail($id);

        $validated = $request->validate([
            'chief_complaint' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string|max:255',
            'encounter_date' => 'nullable|date',
        ]);

        $encounter->update($validated);

        return redirect()->route('patients.show', $encounter->patient_id)
            ->with('success', 'Encounter updated successfully');
    }
}