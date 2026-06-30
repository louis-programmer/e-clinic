<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LicenseService;

class LicenseController extends Controller
{
    public function show()
    {
        return view('license.activate');
    }

    public function activate(Request $request, LicenseService $license)
    {
        $request->validate([
            'activation_code' => 'required'
        ]);

        if (!$license->activate($request->activation_code)) {

            return back()->withErrors([
                'activation_code' => 'Invalid activation code.'
            ]);
        }

        return redirect('/')
            ->with('success', 'License activated successfully.');
    }
}