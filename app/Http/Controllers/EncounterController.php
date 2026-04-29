<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encounter;
use App\Models\Patient;

class EncounterController extends Controller
{
    public function store(Request $request, $patientId)
    {
        // 1. Ensure patient exists (VERY IMPORTANT in EMR)
        $patient = Patient::findOrFail($patientId);

        // 2. Validate input
        $validated = $request->validate([
            'chief_complaint' => 'nullable|string',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string',
        ]);

        // 3. Attach patient
        $validated['patient_id'] = $patient->id;

        // 4. Create encounter
        Encounter::create($validated);

        // 5. Better UX: go back to patient profile
        return redirect("/patients/{$patient->id}")
            ->with('success', 'Encounter added successfully');
    }
}