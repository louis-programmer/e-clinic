<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use App\Models\DentalChartRecord;
use App\Models\PatientTooth;


class DentalChartController extends Controller
{

    public function __construct()
        {
            $this->middleware('auth');

            $this->middleware(
                'role:' . implode(',', config('roles.dental_diagram'))
            )->only([
                'index',
                'show',
                'save',
                'store',
                'update',
                'destroy',
            ]);
        }


    /*
    |--------------------------------------------------------------------------
    | LOAD CHART
    |--------------------------------------------------------------------------
    */
        public function index(Patient $patient)
        {

            $this->authorize('view', $patient); // secure

            $records = DentalChartRecord::where('patient_id', $patient->id)
                ->get();

            $toothStates = PatientTooth::where('patient_id', $patient->id)
                ->get()
                ->keyBy('tooth_number');

            return view('patients.dental-chart', compact(
                'patient',
                'records',
                'toothStates'
            ));
        }

    /*
    |--------------------------------------------------------------------------
    | STORE / UPDATE TOOTH SURFACE
    |--------------------------------------------------------------------------
    */
public function store(Request $request, Patient $patient)
{

     $this->authorize('update', $patient); // secure

    $validated = $request->validate([
        'tooth_number' => ['required', 'string', 'max:10'],
        'surface' => ['required', 'in:top,right,bottom,left,center'],
        'remark' => ['nullable', 'string', 'max:1000'],

        // ADD THIS
        'condition' => ['nullable', 'string', 'max:100'],
    ]);

        DentalChartRecord::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'tooth_number' => $validated['tooth_number'],
                'surface' => $validated['surface'],
            ],
        [
              'remarks' => $validated['remark'],
                 'condition' => $validated['condition'], // ✅ ONLY THIS
                'created_by' => auth()->id(),
        ]
        );


        // ======================================
        // PERSISTENT TOOTH STATE
        // ======================================

        if (!empty($validated['condition'])) {

            PatientTooth::updateOrCreate(
                [
                    'patient_id' => $patient->id,
                    'tooth_number' => $validated['tooth_number'],
                ],
                [
                    'state' => $validated['condition'],
                ]
            );
        }




            return response()->json([
                'success' => true
            ]);
        }
 }