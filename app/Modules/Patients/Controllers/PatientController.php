<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient; // 
use Illuminate\Support\Str;
use App\Enums\AppointmentStatus;
use App\Modules\Patients\Models\Procedure;
use App\Modules\Patients\Models\ProgressNote;
use App\Models\DentalChartRecord;
use App\Models\PatientTooth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(
            'role:' . implode(',', config('roles.patient_view'))
        )->only([
            'index',
            'show',
        ]);

        $this->middleware(
            'role:' . implode(',', config('roles.patient_manage'))
        )->only([
            'create',
            'store',
            'edit',
            'update',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LIST Upgraded with search
    |--------------------------------------------------------------------------
    */
        public function index(Request $request)
        {
            $search = trim($request->get('search'));

            $patients = Patient::query()

                ->when($search, function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('middle_name', 'like', "%{$search}%")
                            ->orWhere('contact_number', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"); // ✅ ADD THIS

                    });

                })

                ->latest()
                ->paginate(10)

                // IMPORTANT
                ->withQueryString();

            return view('patients.index', compact(
                'patients',
                'search'
            ));
        }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('patients.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $this->validatePatient($request);

        $validated['patient_code'] = (string) Str::uuid();

        $patient = Patient::create($validated);

        return redirect('/patients/' . $patient->id)
            ->with('success', 'Patient created successfully');
    }

        /*
        |--------------------------------------------------------------------------
        | SHOW
        |--------------------------------------------------------------------------
        */
        public function show(Patient $patient)
        {

                $this->authorize('view', $patient); //// policy

            $patient->load([
                'encounters',
                'images',
            ]);

            $upcomingAppointments = $patient->appointments()
                ->whereIn('status', AppointmentStatus::active())
                ->whereDate('appointment_date', '>=', now()->toDateString())
                ->orderBy('appointment_date', 'asc')
                ->orderBy('id', 'asc')
                ->paginate(5, ['*'], 'upcoming_page');

            $upcomingAppointments->getCollection()->transform(function ($appointment) {
                $appointment->is_locked = in_array(
                    $appointment->status,
                    AppointmentStatus::final(),
                    true
                );
                return $appointment;
            });

            $previousAppointments = $patient->appointments()
                ->where(function ($query) {
                    $query->whereIn('status', AppointmentStatus::final())
                        ->orWhereDate('appointment_date', '<', now()->toDateString());
                })
                ->orderBy('appointment_date', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(5, ['*'], 'previous_page');

            $previousAppointments->getCollection()->transform(function ($appointment) {
                $appointment->is_locked = in_array(
                    $appointment->status,
                    AppointmentStatus::final(),
                    true
                );
                return $appointment;
            });

            // ✅ ADD THIS HERE (before return)
           $procedures = Procedure::query()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');


            $progressNotes = $patient->progressNotes()
                ->with(['procedure'])
                ->latest()
                ->paginate(10);

              $invoices = $patient->invoices()
                ->with(['items'])
                ->latest()
                ->paginate(5);


                $records = DentalChartRecord::where('patient_id', $patient->id)->get();

                $toothStates = PatientTooth::where('patient_id', $patient->id)
                    ->get()
                    ->keyBy('tooth_number');


            return view('patients.show', compact(
                'patient',
                'upcomingAppointments',
                'previousAppointments',
                'procedures',
                'progressNotes',
                'invoices',
                'records',        // ✅ ADD THIS
                'toothStates'     // ✅ ADD THIS
            ));
        }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $patient = $this->findPatient($id);

        return view('patients.edit', compact('patient'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $patient = $this->findPatient($id);

        $validated = $this->validatePatient(
            $request,
            true
        );

        $patient->update($validated);

        return redirect('/patients/' . $patient->id)
            ->with('success', 'Patient updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function findPatient($id): Patient
    {
        return Patient::query()
            ->findOrFail((int) $id);
    }

    private function validatePatient(
        Request $request,
        bool $isUpdate = false
    ): array {

        $required = $isUpdate
            ? 'nullable'
            : 'required';

        return $request->validate([

            'first_name' => [
                $required,
                'string',
                'max:255',
            ],

            'last_name' => [
                $required,
                'string',
                'max:255',
            ],

            'middle_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contact_number' => [
                $required,
                'string',
                'max:20',
            ],

            'email' => [
            'nullable',
            'email',
            'max:255',
        ],

            'address' => [
                $required,
                'string',
                'max:500',
            ],

            'gender' => [
                $required,
                'in:male,female,other',
            ],

            'birthdate' => [
                $required,
                'date',
                'before_or_equal:today',
            ],
        ]);
    }
}