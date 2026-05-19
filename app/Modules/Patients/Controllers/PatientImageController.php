<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\PatientImage;
use Illuminate\Support\Facades\Storage;

class PatientImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

  

         $this->middleware(
            'role:' . implode(',', config('roles.patient_photos'))
        )->only([
            'store',
        ]);
             
        $this->middleware(
            'role:' . implode(',', config('roles.patient_photos'))
        )->only([
            'destroy',
        ]);


    }

        public function store(Request $request, $patientId)
        {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'type'  => 'required|in:photo,xray',
            ]);

            $type = $validated['type'];

            // safer filename
            $filename = uniqid() . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')->storeAs(
                'patient_images',
                $filename,
                'public'
            );

            PatientImage::create([
                'patient_id'  => $patientId,
                'file_path'   => $path,
                'uploaded_by' => auth()->id(),
                'type'        => $type,
            ]);

            return back()->with('success', 'Image uploaded');
        }



        public function destroy($id)
        {
            $image = PatientImage::where('id', $id)
                ->whereHas('patient') // ensures relation exists
                ->firstOrFail();

            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            $image->delete();

            return back()->with('success', 'Image deleted successfully');
        }

}