<?php

namespace App\Modules\Patients\Controllers;
use App\Modules\Patients\Models\Procedure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;

class ProgressNoteController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(
            'role:' . implode(',', config('roles.progress_notes'))
        )->only([
            'store',
        ]);
    }
            
    public function store(Request $request, Patient $patient)
    {

          $this->authorize('update', $patient);


        $validated = $request->validate([
            'procedure_id' => 'required|exists:procedures,id',
            'remarks' => 'nullable|string|max:5000',
        ]);

        $patient->progressNotes()->create([
            'procedure_id' => $validated['procedure_id'],
            'remarks' => $validated['remarks'],
            'created_by' => auth()->id(),
        ]);

        return back()->with('SUCCESS!', 'Progress note saved');
    }
}