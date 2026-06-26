<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientImportController extends Controller
{
    public function index()
    {
        return view('patients.import');
    }

    public function store(Request $request)
    {

    
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = fopen($request->file('csv_file')->getRealPath(), 'r');

        if (!$file) {
            dd('Cannot open file');
        }

        // Skip CSV header
        fgetcsv($file);
      

           


        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {

            while (($row = fgetcsv($file)) !== false) {

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                /*
                -------------------------------------------------------
                CSV Columns
                -------------------------------------------------------
                0  ID
                1  Patient
                2  Birthday
                3  Gender
                4  Address
                5  Email
                6  Contact
                7  Civil Status
                8  Occupation
                9  Religion
                10 Remarks
                11 Tags
                */

                $legacyId = trim($row[0]);

                // Skip if already imported
                if (Patient::where('legacy_id', $legacyId)->exists()) {
                    $skipped++;
                    continue;
                }

                $fullName = trim($row[1]);

                // Remove "(ID:x)"
                $fullName = preg_replace('/^\(ID:\s*\d+\)\s*/', '', $fullName);

                $lastName = '';
                $firstName = '';
                $middleName = '';

                if (str_contains($fullName, ',')) {

                    [$lastName, $rest] = array_map(
                        'trim',
                        explode(',', $fullName, 2)
                    );

                    $parts = preg_split('/\s+/', $rest);

                    if (count($parts) >= 2) {
                        $middleName = array_pop($parts);
                    }

                    $firstName = implode(' ', $parts);
                }

                Patient::create([

                    'clinic_id' => config('clinic.id'),

                    'patient_code'   => (string) Str::uuid(),

                    'legacy_id'      => $legacyId,
                    'is_legacy'      => true,

                    'first_name'     => $firstName,
                    'last_name'      => $lastName,
                    'middle_name'    => $middleName,

                    'birthdate'      => !empty($row[2]) ? substr($row[2], 0, 10) : null,
                    'gender'         => $row[3] ?: null,
                    'address'        => $row[4] ?: null,
                    'email'          => $row[5] ?: null,
                    'contact_number' => $row[6] ?: null,
                    'civil_status'   => $row[7] ?: null,
                    'occupation'     => $row[8] ?: null,
                    'tags'           => $row[11] ?: null,

                ]);

                $imported++;
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            fclose($file);

            return back()->withErrors([
                'csv_file' => $e->getMessage()
            ]);
        }

        fclose($file);

        return redirect()
            ->route('patients.index')
            ->with(
                'success',
                "{$imported} patient(s) imported successfully. {$skipped} duplicate(s) skipped."
            );
    }
}