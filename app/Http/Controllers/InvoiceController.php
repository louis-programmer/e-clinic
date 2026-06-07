<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ClinicProfile;
class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Invoice $invoice)
    {
         $this->authorize('view', $invoice->patient); // secure
        $invoice->load([
            'patient',
            'items.procedure',
            'payments',
        ]);

        $clinic = ClinicProfile::first();

       return view('invoices.show', compact(
                'invoice',
                'clinic'
            ));
    }
}