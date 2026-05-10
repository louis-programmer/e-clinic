<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use Illuminate\Support\Str;
use App\Enums\AppointmentStatus;

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

        /*
        |--------------------------------------------------------------------------
        | UPCOMING APPOINTMENTS
        |--------------------------------------------------------------------------
        */
        $upcomingAppointments = $patient->appointments()
            ->whereIn('status', AppointmentStatus::active())
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(5, ['*'], 'upcoming_page');

        /*
        |--------------------------------------------------------------------------
        | REMOVE BUSINESS LOGIC FROM BLADE
        |--------------------------------------------------------------------------
        */
        $upcomingAppointments->getCollection()->transform(function ($appointment) {

            $appointment->is_locked = in_array(
                $appointment->status,
                AppointmentStatus::final()
            );

            return $appointment;
        });

        /*
        |--------------------------------------------------------------------------
        | PREVIOUS APPOINTMENTS
        |--------------------------------------------------------------------------
        */
        $previousAppointments = $patient->appointments()
            ->where(function ($query) {

                $query->whereIn(
                    'status',
                    AppointmentStatus::final()
                )

                ->orWhereDate(
                    'appointment_date',
                    '<',
                    now()->toDateString()
                );
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(5, ['*'], 'previous_page');

        /*
        |--------------------------------------------------------------------------
        | REMOVE BUSINESS LOGIC FROM BLADE
        |--------------------------------------------------------------------------
        */
        $previousAppointments->getCollection()->transform(function ($appointment) {

            $appointment->is_locked = in_array(
                $appointment->status,
                AppointmentStatus::final()
            );

            return $appointment;
        });

        return view('patients.show', compact(
            'patient',
            'upcomingAppointments',
            'previousAppointments'
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
    | Helpers
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
            'first_name'     => $required . '|string|max:255',
            'last_name'      => $required . '|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'contact_number' => $required . '|string|max:20',
            'address'        => $required . '|string|max:500',
            'gender'         => $required . '|in:male,female,other',
            'birthdate'      => $required . '|date',
        ]);
    }
}