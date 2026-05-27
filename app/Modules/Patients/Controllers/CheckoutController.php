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

            // DISCOUNT
            'discount_type' => 'nullable|in:percent,fixed',
            'discount_value' => 'nullable|numeric|min:0|max:100000',
        ]);

        if (($validated['discount_type'] ?? null) === 'percent'
            && ($validated['discount_value'] ?? 0) > 100) {

            $validated['discount_value'] = 100;
        }


        DB::transaction(function () use ($validated, $patient) {

            // =====================================================
            // FETCH PROCEDURES
            // =====================================================
            $procedures = Procedure::whereIn(
                'id',
                $validated['procedures']
            )->get();

            // =====================================================
            // SUBTOTAL (MOVE UP - REQUIRED CHANGE)
            // =====================================================
            $subtotal = 0;

            foreach ($procedures as $procedure) {
                $subtotal += $procedure->price;
            }

            // =====================================================
            // DISCOUNT LOGIC (MOVE UP - REQUIRED CHANGE)
            // =====================================================
            $discountType = $validated['discount_type'] ?? null;
            $discountValue = (float) ($validated['discount_value'] ?? 0);

            $discountAmount = 0;

            if ($discountType === 'percent') {
                $discountAmount = ($subtotal * $discountValue) / 100;
            }

            if ($discountType === 'fixed') {
                $discountAmount = $discountValue;
            }

            // Safety guard
            $discountAmount = min($discountAmount, $subtotal);

            $total = max(0, $subtotal - $discountAmount);

            // =====================================================
            // CREATE INVOICE (NOW CORRECT VALUES)
            // =====================================================
            $invoice = $patient->invoices()->create([
                'invoice_number' => 'INV-' . now()->format('YmdHis'),

                'subtotal' => $subtotal,

                'discount_amount' => $discountAmount,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,

                'total' => $total,
                'balance' => $total,

                'paid_amount' => 0,
                'status' => 'unpaid',
                'remarks' => $validated['remarks'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // =====================================================
            // CREATE ITEMS
            // =====================================================
            foreach ($procedures as $procedure) {

                $invoice->items()->create([
                    'procedure_id' => $procedure->id,
                    'description' => $procedure->name,
                    'qty' => 1,
                    'unit_price' => $procedure->price,
                    'line_total' => $procedure->price,
                ]);
            }
        });

        // =====================================================
        // REDIRECT
        // =====================================================
        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Checkout / Invoice created successfully');
    }
}