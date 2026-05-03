<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encounter;
use App\Modules\Patients\Models\Patient;

class EncounterController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('role:' . implode(',', config('roles.encounter_view')))
            ->only(['index', 'show']);

        $this->middleware('role:' . implode(',', config('roles.encounter_manage')))
            ->only(['create', 'store', 'edit', 'update']);

        $this->middleware('role:' . implode(',', config('roles.encounter_delete')))
            ->only(['destroy']);
    }



    public function store(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        $validated = $request->validate([
            'chief_complaint' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'diagnosis' => 'nullable|string|max:255',
            'encounter_date' => 'nullable|date',

        ]);

        $validated['encounter_date'] = $validated['encounter_date'] ?? now();

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

        $validated['encounter_date'] = $validated['encounter_date'] ?? now();
        
        $encounter->update($validated);

        return redirect()->route('patients.show', $encounter->patient_id)
            ->with('success', 'Encounter updated successfully');
    }


}