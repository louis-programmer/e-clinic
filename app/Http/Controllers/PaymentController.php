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
        // =====================================================
        // VALIDATION
        // =====================================================
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'method' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        // =====================================================
        // SAFETY: REFRESH INVOICE (IMPORTANT)
        // =====================================================
        $invoice->refresh();

        // =====================================================
        // OVERPAYMENT CHECK
        // =====================================================
        $amount = round($validated['amount'], 2);
        $balance = round($invoice->balance, 2);

        if ($amount > $balance) {
            return back()->with(
                'error',
                'Payment exceeds remaining invoice balance. Max allowed: ₱' . number_format($balance, 2)
            );
        }

        // =====================================================
        // TRANSACTION: PAYMENT + INVOICE UPDATE
        // =====================================================
            DB::transaction(function () use ($validated, $invoice) {

                // IMPORTANT: always refresh inside transaction
                $invoice->refresh();

                // Create payment
                $payment = $invoice->payments()->create([
                    'amount' => $validated['amount'],
                    'method' => $validated['method'],
                    'notes' => $validated['notes'],
                    'created_by' => auth()->id(),
                ]);

                // Recalculate safely
                $newPaidAmount = $invoice->paid_amount + $payment->amount;

                // IMPORTANT: discount-safe balance calculation
                $newBalance = max(0, $invoice->total - $newPaidAmount);

                $status = 'partial';

                if ($newBalance <= 0) {
                    $status = 'paid';
                    $newBalance = 0;
                }

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