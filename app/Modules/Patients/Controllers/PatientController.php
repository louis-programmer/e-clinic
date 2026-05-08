<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use Illuminate\Support\Str;


class PatientController extends Controller
{

    public function __construct()
        {
            $this->middleware('auth');

            $this->middleware('role:' . implode(',', config('roles.patient_view')))
                ->only(['index', 'show']);

            $this->middleware('role:' . implode(',', config('roles.patient_manage')))
                ->only(['create', 'store', 'edit', 'update']);
        }


    public function index()
    {
        $patients = Patient::latest()->paginate(10);

        return view('patients.index', compact('patients'));
    }



    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePatient($request);

        #$validated['patient_code'] = Str::uuid(); // or custom format
        $validated['patient_code'] = (string) Str::uuid();

        $patient = Patient::create($validated);      

        return redirect('/patients/' . $patient->id)
            ->with('success', 'Patient created successfully');
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'encounters',
            'images',
        ]);

        $appointments = $patient->appointments()
            ->latest('appointment_date')
            ->paginate(5);

        return view('patients.show', compact(
            'patient',
            'appointments'
        ));
    }

    
    public function edit($id)
    {
        $patient = $this->findPatient($id);

        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = $this->findPatient($id);

        $validated = $this->validatePatient($request, $isUpdate = true);

        $patient->update($validated);

        return redirect('/patients/' . $patient->id)
            ->with('success', 'Patient updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (important for clean code)
    |--------------------------------------------------------------------------
    */

    private function findPatient($id)
    {
        return Patient::findOrFail($id);
    }

    private function validatePatient(Request $request, $isUpdate = false)
    {
        $required = $isUpdate ? 'nullable' : 'required';

        return $request->validate([
            'first_name' => $required . '|string|max:255',
            'last_name' => $required . '|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'contact_number' => $required . '|string|max:20',
            'address' => $required . '|string|max:500',
            'gender' => $required . '|in:male,female,other',
            'birthdate' => $required . '|date',
        ]);
    }

        
          


          ////


}