<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'condition_name' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:active,resolved,chronic',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $patient->medicalHistories()->create($validated);

        return back()->with(
            'success',
            'Medical condition added.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Medical History
    |--------------------------------------------------------------------------
    */
    public function destroy(
        Patient $patient,
        MedicalHistory $history
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ownership Validation
        |--------------------------------------------------------------------------
        */
        if ((int) $history->patient_id !== (int) $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        $history->delete();

        return back()->with(
            'success',
            'Condition removed.'
        );
    }
}