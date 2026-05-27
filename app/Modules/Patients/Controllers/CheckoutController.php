<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use App\Modules\Patients\Models\Procedure;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request, Patient $patient)
    {

        $this->authorize('update', $patient);
        // =====================================================
        // VALIDATION
        // =====================================================
        $validated = $request->validate([
            'procedures' => 'required|array',
            'procedures.*' => 'exists:procedures,id',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $patient) {

            // =====================================================
            // FETCH SELECTED PROCEDURES
            // =====================================================
            $procedures = Procedure::whereIn(
                'id',
                $validated['procedures']
            )->get();

            // =====================================================
            // CREATE INVOICE
            // =====================================================
            $invoice = $patient->invoices()->create([
                'invoice_number' => 'INV-' . now()->format('YmdHis'),
                'subtotal' => 0,
                'total' => 0,
                'paid_amount' => 0,
                'balance' => 0,
                'status' => 'unpaid',
                'remarks' => $validated['remarks'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // =====================================================
            // COMPUTE TOTAL + CREATE ITEMS
            // =====================================================
            $subtotal = 0;

            foreach ($procedures as $procedure) {

                $lineTotal = $procedure->price;

                $invoice->items()->create([
                    'procedure_id' => $procedure->id,
                    'description' => $procedure->name,
                    'qty' => 1,
                    'unit_price' => $procedure->price,
                    'line_total' => $lineTotal,
                ]);

                $subtotal += $lineTotal;
            }

            // =====================================================
            // UPDATE INVOICE TOTALS
            // =====================================================
            $invoice->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'balance' => $subtotal,
            ]);
        });

        // =====================================================
        // REDIRECT BACK TO PATIENT
        // =====================================================
        return redirect()
            ->route('patients.show', $patient)
            ->with('success!!', 'Checkout / Invoice created successfully');
    }
}