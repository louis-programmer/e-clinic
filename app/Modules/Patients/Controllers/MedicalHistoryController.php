<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modules\Patients\Models\Patient;
use App\Modules\Patients\Models\MedicalHistory;

class MedicalHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(
            'role:' . implode(',', config('roles.overview_history'))
        )->only([
            'store',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Medical History
    |--------------------------------------------------------------------------
    */

public function store(Request $request, Patient $patient)
{
    $validated = $request->validate([
        'conditions' => ['nullable', 'array'],
        'conditions.*' => ['string', 'max:255'],
        'other_condition' => ['nullable', 'string', 'max:255'],
        'status' => ['required', 'in:active,resolved,chronic'],
        'notes' => ['nullable', 'string', 'max:5000'],
    ]);

    $conditions = $validated['conditions'] ?? [];

    // Add "other condition" if provided
    if (!empty($validated['other_condition'])) {
        $conditions[] = $validated['other_condition'];
    }

    foreach ($conditions as $condition) {

        // Prevent duplicates
        $exists = $patient->medicalHistories()
            ->where('condition_name', $condition)
            ->exists();

        if ($exists) {
            continue;
        }

        $patient->medicalHistories()->create([
            'condition_name' => $condition,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);
    }

    return back()->with('success', 'Medical conditions added.');
}

    /*
    |--------------------------------------------------------------------------
    | Delete Medical History
    |--------------------------------------------------------------------------
    */
    public function destroy(Patient $patient, MedicalHistory $history)
    {
        if ((int) $history->patient_id !== (int) $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        $history->delete();

        return back()->with('success', 'Condition removed.');
    }
}