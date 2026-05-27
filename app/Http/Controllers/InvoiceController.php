<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

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

        return view('invoices.show', compact('invoice'));
    }
}