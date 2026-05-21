<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        // 1. Create payment record
        $invoice->payments()->create([
            'amount' => $validated['amount'],
            'method' => $validated['method'] ?? 'cash',
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // 2. Recalculate totals
        $paid = $invoice->payments()->sum('amount');

        $invoice->update([
            'paid_amount' => $paid,
            'balance' => $invoice->total - $paid,
            'status' => $paid >= $invoice->total
                ? 'paid'
                : ($paid > 0 ? 'partial' : 'unpaid'),
        ]);

        return back()->with('success', 'Payment recorded successfully');
    }
}