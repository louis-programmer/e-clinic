<?php

namespace App\Http\Controllers;
use App\Modules\Patients\Models\Patient;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // controlled via config (production-ready)
        $this->middleware('role:' . implode(',', config('roles.scan_access')));
    }

    public function index()
    {
        return view('scan.index');
    }

    public function store(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $code = trim($request->input('code'));

        // 2. Find patient
        #$patient = \App\Modules\Patients\Models\Patient::where('patient_code', $code)->first();
        $patient = Patient::where('patient_code', $code)->first();
        
        if (!$patient) {
            return back()->with('error', 'Patient not found');
        }

        // 3. Log scan (temporary)
        \Log::info('Scan success', [
            'user_id' => auth()->id(),
            'patient_id' => $patient->id,
        ]);

        // 4. Return success
        return back()->with('success', 'Scan successful for ' . $patient->first_name . ' ' . $patient->last_name);

    }


}