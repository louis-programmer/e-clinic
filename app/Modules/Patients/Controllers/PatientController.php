<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;

class PatientController extends Controller
{
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

        $patient = Patient::create($validated);

        return redirect('/patients/' . $patient->id)
            ->with('success', 'Patient created successfully');
    }

    public function show($id)
    {
        $patient = Patient::with(['encounters' => function ($query) {
            $query->orderBy('encounter_date', 'desc');
        }])->findOrFail($id);

        return view('patients.show', compact('patient'));
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

        public function __construct()
        {
            $this->middleware('auth');

            // Only admin + staff can view patients list
            $this->middleware('role:admin,staff')->only(['index']);

            // Only admin can create/update
            $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update']);
        }

        

}