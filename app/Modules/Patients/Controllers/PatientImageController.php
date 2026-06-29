<?php

namespace App\Modules\Patients\Controllers;
use App\Modules\Patients\Models\Patient;
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
        );


    }


       public function store(Request $request, Patient $patient)
        {

            $this->authorize('update', $patient);

            $validated = $request->validate([
                #'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:20480',
                'type'  => 'required|in:photo,xray',
            ]);

            $type = $validated['type'];

            if (!in_array($type, ['photo', 'xray'])) {
                    abort(422, 'Invalid image type');
                }

            // safer filename
            $filename = uniqid() . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();

/*
                $folder = $type === 'xray'
                    ? 'patients/xrays'
                    : 'patients/photos';

*/

/*
                    $folder = 'patients/'
                        . $patient->id
                        . '/'
                        . ($type === 'xray' ? 'xrays' : 'photos');

*/

                        // uses clinic config
                       $folder = config('clinic.images.base_path')
                                . '/'
                                . $patient->id
                                . '/'
                                . (
                                    $type === 'xray'
                                        ? config('clinic.folders.xrays')
                                        : config('clinic.folders.photos')
                                );



                $path = $request->file('image')->storeAs(
                    $folder,
                    $filename,
                    'public'
                );

            PatientImage::create([
                  'patient_id'  => $patient->id,
                'file_path'   => $path,
                'uploaded_by' => auth()->id(),
                'type'        => $type,
            ]);

            return back()->with('success', 'Image uploaded');
        }



        public function destroy(PatientImage $image)
        {

            $this->authorize('update', $image->patient);

            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }

            $image->delete();

            return back()->with('success', 'Image deleted successfully');
        }

}