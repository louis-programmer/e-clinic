<?php

namespace App\Http\Controllers;

use App\Models\ClinicProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClinicProfileController extends Controller
{

    public function __construct()
        {
            $this->middleware('auth');

            $this->middleware(
                'role:' . implode(',', config('roles.clinic_profile_manage'))
            );
        }


    public function edit()
    {
        $profile = ClinicProfile::firstOrCreate(
            ['id' => 1],
            [
                'clinic_name' => 'My Clinic',
            ]
        );

        return view(
            'clinic-profile.edit',
            compact('profile')
        );
    }


            public function update(Request $request)
            {
                $validated = $request->validate([
                    'clinic_name' => ['required', 'string', 'max:255'],

                    'contact_number' => ['nullable', 'string', 'max:50'],

                    'email' => ['nullable', 'email', 'max:255'],

                    'address' => ['nullable', 'string'],

                    'payment_methods' => ['nullable', 'string'],

                    'logo' => [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png,webp',
                        'max:2048',
                    ],

                        'gcash_qr' => [
                            'nullable',
                            'image',
                            'mimes:jpg,jpeg,png,webp',
                            'max:2048',
                        ],

                        'maya_qr' => [
                            'nullable',
                            'image',
                            'mimes:jpg,jpeg,png,webp',
                            'max:2048',
                        ],

                        'bank_name' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],

                        'bank_account_name' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],

                        'bank_account_number' => [
                            'nullable',
                            'string',
                            'max:255',
                        ],



                        'enabled_payment_methods' => [
                            'nullable',
                            'array',
                        ],

                ]);



                $profile = ClinicProfile::firstOrFail();

                if ($request->hasFile('logo')) {

                    if ($profile->logo_path) {

                        Storage::disk('public')
                            ->delete($profile->logo_path);
                    }

                    $profile->logo_path =
                        $request->file('logo')
                            ->store('clinic-logos', 'public');
                }

                if ($request->hasFile('gcash_qr')) {

                    $path = $request->file('gcash_qr')
                        ->store('clinic-config/gcash', 'public');

                    $profile->gcash_qr_path = $path;
                }

                if ($request->hasFile('maya_qr')) {

                    $path = $request->file('maya_qr')
                        ->store('clinic-config/maya', 'public');

                    $profile->maya_qr_path = $path;
                }



                $profile->clinic_name =
                    $validated['clinic_name'];

                $profile->contact_number =
                    $validated['contact_number'] ?? null;

                $profile->email =
                    $validated['email'] ?? null;

                $profile->address =
                    $validated['address'] ?? null;

                $profile->payment_methods =
                    $validated['payment_methods'] ?? null;

                    $profile->bank_name =
                        $validated['bank_name'] ?? null;

                    $profile->bank_account_name =
                        $validated['bank_account_name'] ?? null;

                    $profile->bank_account_number =
                        $validated['bank_account_number'] ?? null;
                        
                    $profile->enabled_payment_methods =
                        $validated['enabled_payment_methods'] ?? [];


                $profile->save();

                return back()->with(
                    'success',
                    'Clinic profile updated successfully.'
                );
            }


}