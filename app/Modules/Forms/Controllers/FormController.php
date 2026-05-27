<?php

namespace App\Modules\Forms\Controllers;
use App\Modules\Patients\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Modules\Forms\Models\PatientForm;

class FormController extends Controller
{
   public function store(Request $request, Patient $patient)
    {

        $this->authorize('update', $patient);

        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'remarks'  => 'nullable|string',
            'file'     => 'required|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $path = $request->file('file')->store('patient-forms');

        PatientForm::create([
           'patient_id' => $patient->id,
            'title'      => $data['title'],
            'category'   => $data['category'],
            'remarks'    => $data['remarks'] ?? null,
            'file_path'  => $path,
        ]);

        return back()->with('success', 'Form uploaded successfully.');
    }

   public function view(Patient $patient, PatientForm $form)
    {

        $this->authorize('view', $patient);
        // SECURITY: ensure form belongs to patient
        if ((int) $form->patient_id !== (int) $patient->id){
            abort(403, 'Unauthorized access.');
        }

        $path = storage_path('app/' . $form->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function destroy(Patient $patient, PatientForm $form)
    {

         $this->authorize('update', $patient);
        // SECURITY: ensure form belongs to patient
        if ((int) $form->patient_id !== (int) $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        Storage::delete($form->file_path);

        $form->delete();

        return back()->with('success', 'Form deleted successfully.');
    }
}