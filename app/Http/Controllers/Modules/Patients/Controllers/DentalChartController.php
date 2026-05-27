<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Patients\Models\Patient;
use App\Modules\Patients\Models\DentalChartRecord;

class DentalChartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STORE / UPDATE RECORD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([

            'tooth_number' => [
                'required',
                'string',
                'max:10',
            ],

            'surface' => [
                'required',
                'in:top,right,bottom,left,center',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE OR CREATE
        |--------------------------------------------------------------------------
        */
        $record = DentalChartRecord::updateOrCreate(

            [
                'patient_id' => $patient->id,
                'tooth_number' => $validated['tooth_number'],
                'surface' => $validated['surface'],
            ],

            [
                'remarks' => $validated['remarks'],
                'created_by' => auth()->id(),
            ]
        );

        return response()->json([
            'success' => true,
            'record' => $record,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD RECORDS
    |--------------------------------------------------------------------------
    */
    public function index(Patient $patient)
    {
        return response()->json(

            $patient->dentalChartRecords()->get()

        );
    }
}