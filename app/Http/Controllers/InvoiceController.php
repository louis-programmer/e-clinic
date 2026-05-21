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
        $invoice->load([
            'patient',
            'items.procedure',
            'payments',
        ]);

        return view('invoices.show', compact('invoice'));
    }
}