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

        // upload/view allowed
        $this->middleware('role:admin,staff,doctor');

        // delete restricted
        $this->middleware('role:admin,staff')->only(['destroy']);

    }

    public function store(Request $request, $patientId)
    {
        $request->validate([
            # 'image' => 'required|image|max:2048',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ HERE (file naming logic)
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();

        $path = $request->file('image')->storeAs('patient_images', $filename, 'public');
        PatientImage::create([
            'patient_id' => $patientId,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Image uploaded');
    }



    public function destroy($id)
    {
       # $image = PatientImage::findOrFail($id);
        $image = PatientImage::where('id', $id)
            ->whereHas('patient', function ($q) {
                // optional: scope by clinic later
            })
            ->firstOrFail(); # (We’ll refine this later when you add multi-clinic support)

        // delete file from storage
        if (Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }

        // delete DB record
        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }


}