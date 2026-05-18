<?php

namespace App\Modules\Patients\Controllers;
use App\Modules\Patients\Models\Procedure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;

class ProgressNoteController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'remarks' => 'nullable|string',
        ]);

        $patient->progressNotes()->create([
            'procedure_id' => $validated['procedure_id'],
            'remarks' => $validated['remarks'],
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Progress note saved');
    }
}