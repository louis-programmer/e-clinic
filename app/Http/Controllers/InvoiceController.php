<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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



    public function void(Request $request, Invoice $invoice)
{
    if ($invoice->is_void) {
        return back()->with('error', 'Invoice already voided.');
    }

    $invoice->update([
        'is_void' => true,
        'voided_at' => now(),
        'voided_by' => auth()->id(),
        'void_reason' => $request->void_reason,
    ]);

    return back()->with(
        'success',
        'Invoice voided successfully.'
    );
}

}