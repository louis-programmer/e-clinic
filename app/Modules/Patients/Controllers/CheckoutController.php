<?php

namespace App\Modules\Patients\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Patients\Models\Patient;
use App\Modules\Patients\Models\Procedure;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        // =====================================================
        // VALIDATION
        // =====================================================
        $validated = $request->validate([
            'procedures' => 'nullable|array',
            'procedures.*' => 'exists:procedures,id',

            'custom_procedure_name' => 'nullable|array',
            'custom_procedure_name.*' => 'nullable|string|max:255',

            'custom_procedure_price' => 'nullable|array',
            'custom_procedure_price.*' => 'nullable|numeric|min:0',

            'custom_prices' => 'nullable|array',
            'custom_prices.*' => 'nullable|numeric|min:0',

            'remarks' => 'nullable|string',

            'discount_type' => 'nullable|in:percent,fixed',
            'discount_value' => 'nullable|numeric|min:0|max:100000',
            'signature' => 'nullable|string',

        ]);

        if (
            empty($validated['procedures']) &&
            empty($validated['custom_procedure_name'])
        ) {
            return back()->with('error', 'Please select at least one procedure.');
        }

        if (($validated['discount_type'] ?? null) === 'percent'
            && ($validated['discount_value'] ?? 0) > 100) {
            $validated['discount_value'] = 100;
        }

        DB::transaction(function () use ($validated, $patient, $request) {

            // =====================================================
            // FETCH DATA
            // =====================================================
            $procedures = Procedure::whereIn(
                'id',
                $validated['procedures'] ?? []
            )->get();

            $customNames = $validated['custom_procedure_name'] ?? [];
            $customPrices = $validated['custom_procedure_price'] ?? [];

            $subtotal = 0;

            // =====================================================
            // PROCEDURES SUBTOTAL
            // =====================================================
            foreach ($procedures as $procedure) {

                $price = $procedure->price;

                $override = $validated['custom_prices'][$procedure->id] ?? null;

                if (
                    config('procedures.manual_price_enabled') &&
                    $override !== null &&
                    $override !== ''
                ) {
                    $price = (float) $override;
                }

                $subtotal += $price;
            }

            // =====================================================
            // CUSTOM PROCEDURES (OTHERS) + VALIDATION
            // =====================================================
            foreach ($customNames as $index => $name) {

                $name = trim($name);
                $price = $customPrices[$index] ?? null;

                // ❌ HARD BLOCK: price exists but no name
                if (($price !== null && $price > 0) && $name === '') {
                    throw ValidationException::withMessages([
                        'custom_procedure_name' =>
                            'Please provide a name for all custom procedures with a price.'
                    ]);
                }

                // skip empty valid rows
                if ($name === '' || !is_numeric($price) || $price <= 0) {
                    continue;
                }

                $subtotal += (float) $price;
            }

            // =====================================================
            // DISCOUNT
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

            $discountAmount = min($discountAmount, $subtotal);
            $total = max(0, $subtotal - $discountAmount);

            // =====================================================
            // CREATE INVOICE
            // =====================================================

            $signaturePath = null;

                if (!empty($validated['signature'])) {

                    $signatureData = $validated['signature'];

                    // remove base64 header
                    $signatureData = preg_replace(
                        '#^data:image/\w+;base64,#i',
                        '',
                        $signatureData
                    );

                    $signatureBinary = base64_decode($signatureData);

                    if ($signatureBinary !== false) {

                        $filename =
                            'signature_' .
                            uniqid() .
                            '_' .
                            time() .
                            '.png';

                        $path = 'invoice-signatures/' . $filename;

                        \Storage::put($path, $signatureBinary);

                        $signaturePath = $path;
                    }
                }


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
                'signature_path' => $signaturePath,
                'created_by' => auth()->id(),
            ]);

            // =====================================================
            // INVOICE ITEMS - PROCEDURES
            // =====================================================
            foreach ($procedures as $procedure) {

                $price = $procedure->price;

                $override = $validated['custom_prices'][$procedure->id] ?? null;

                if (
                    config('procedures.manual_price_enabled') &&
                    $override !== null &&
                    $override !== ''
                ) {
                    $price = (float) $override;
                }

                $invoice->items()->create([
                    'procedure_id' => $procedure->id,
                    'description' => $procedure->name,
                    'qty' => 1,
                    'unit_price' => $price,
                    'line_total' => $price,
                ]);
            }

            // =====================================================
            // INVOICE ITEMS - CUSTOM PROCEDURES
            // =====================================================
            foreach ($customNames as $index => $name) {

                $name = trim($name);
                $price = $customPrices[$index] ?? null;

                if (($price !== null && $price > 0) && $name === '') {
                    throw ValidationException::withMessages([
                        'custom_procedure_name' =>
                            'Please provide a name for all custom procedures with a price.'
                    ]);
                }

                if ($name === '' || !is_numeric($price) || $price <= 0) {
                    continue;
                }

                $invoice->items()->create([
                    'procedure_id' => null,
                    'description' => $name . ' (Others)',
                    'qty' => 1,
                    'unit_price' => (float) $price,
                    'line_total' => (float) $price,
                ]);
            }
        });

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Checkout / Invoice created successfully');
    }
}