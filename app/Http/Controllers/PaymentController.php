<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class PaymentController extends Controller
{
    public function store(Request $request, Invoice $invoice)
    {




          $this->authorize('update', $invoice->patient);
           # $this->authorize('update', $invoice);

          $invoice = Invoice::where('id', $invoice->id)
                ->whereHas('patient', function ($q) {
                    $q->where('clinic_id', auth()->user()->clinic_id);
                })
                ->firstOrFail();


                if ($invoice->status === 'paid') {
                    return back()->with('error', 'Invoice already fully paid.');
                }


        // =====================================================
        // VALIDATION
        // =====================================================
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'method' => ['required',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
            
            #'method' => ['required', 'string'],
        ]);

        // =====================================================
        // SAFETY: REFRESH INVOICE (IMPORTANT)
        // =====================================================
        #$invoice->refresh();

        // =====================================================
        // OVERPAYMENT CHECK
        // =====================================================
  /*
        $amount = round($validated['amount'], 2);
        $balance = round($invoice->balance, 2);

        if ($amount > $balance) {
            return back()->with(
                'error',
                'Payment exceeds remaining invoice balance. Max allowed: ₱' . number_format($balance, 2)
            );
        }
*/

        if ($validated['amount'] > $invoice->balance) {
            return back()->with(
                'error',
                'Payment exceeds remaining invoice balance. Max allowed: ₱' . number_format($invoice->balance, 2)
            );
        }

        // =====================================================
        // TRANSACTION: PAYMENT + INVOICE UPDATE
        // =====================================================
              DB::transaction(function () use ($validated, $invoice) {

                $invoice = Invoice::where('id', $invoice->id)
                    ->lockForUpdate()
                    ->first();

                // Re-check balance after obtaining lock
                if ($validated['amount'] > $invoice->balance) {
                    throw new \Exception(
                        'Payment exceeds remaining invoice balance.'
                    );
                }

                $payment = $invoice->payments()->create([
                    'amount' => $validated['amount'],
                    'method' => $validated['method'],
                    'notes' => $validated['notes'],
                    'created_by' => auth()->id(),
                ]);

                $newPaidAmount = $invoice->payments()->sum('amount');

                $newBalance = max(
                    0,
                    $invoice->total - $newPaidAmount
                );

                $status = $newBalance <= 0
                    ? 'paid'
                    : 'partial';

                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'balance' => $newBalance,
                    'status' => $status,
                ]);
            });

        // =====================================================
        // SUCCESS RESPONSE
        // =====================================================
        return back()->with(
            'success',
            'Payment added successfully.'
        );
    }
}