@extends('layouts.app')

@section('content')

@if(session('error'))

    <div style="
        background:#fee2e2;
        border:1px solid #fecaca;
        color:#991b1b;
        padding:14px 16px;
        border-radius:10px;
        margin-bottom:20px;
        font-weight:600;
    ">
        {{ session('error') }}
    </div>

@endif



@if(session('success'))

    <div style="
        background:#dcfce7;
        border:1px solid #bbf7d0;
        color:#166534;
        padding:14px 16px;
        border-radius:10px;
        margin-bottom:20px;
        font-weight:600;
    ">
        {{ session('success') }}
    </div>

@endif

<div class="invoice-print" style="
    max-width:1100px;
    margin:auto;
">

<div id="invoice-print-area">

    {{-- ===================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ===================================================== --}}
    <div class="card" style="margin-bottom:20px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
        ">

                        <button onclick="window.print()" class="btn btn-secondary">
                                🖨 Print Invoice
                            </button>

                            <div>

                                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:20px;
                    border-bottom:1px solid #e2e8f0;
                    padding-bottom:15px;
                ">

                    <div style="display:flex; gap:15px; align-items:center;">

                        @if($clinic->logo_path)
                            <img src="{{ asset('storage/' . $clinic->logo_path) }}"
                                 style="width:60px; height:60px; object-fit:contain;">
                        @endif

                        <div>
                            <div style="font-size:18px; font-weight:700;">
                                {{ $clinic->clinic_name }}
                            </div>

                            <div style="font-size:12px; color:#64748b;">
                                {{ $clinic->address }}
                            </div>
                        </div>

                    </div>

                </div>



                <h2 style="margin:0;">
                    Invoice Details
                </h2>

                <div style="
                    color:#64748b;
                    margin-top:6px;
                ">
                    Invoice #: {{ $invoice->invoice_number }}
                </div>

            </div>

            <a href="{{ route('patients.show', $invoice->patient_id) }}"
               class="btn btn-secondary">
                ← Back to Patient
            </a>

        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- PATIENT + BILLING SUMMARY --}}
    {{-- ===================================================== --}}
    <div class="card" style="margin-bottom:20px;">

        <h3 style="margin-top:0;">
            Billing Summary
        </h3>

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
            gap:16px;
        ">

            <div>
                <div style="font-size:13px; color:#64748b;">
                    Patient
                </div>

                <div style="font-weight:600;">
                    {{ $invoice->patient->full_name }}
                </div>
            </div>

            <div>
                <div style="font-size:13px; color:#64748b;">
                    Invoice Status
                </div>



                <div style="font-weight:600;">
                    {{ ucfirst($invoice->status) }}
                </div>
            </div>


            <div>
                <div style="font-size:13px; color:#64748b;">
                    Invoice Date
                </div>

                <div style="font-weight:600;">
                    {{ $invoice->created_at->format('M d, Y h:i A') }}
                </div>
            </div>

         <div>
    <div style="font-size:13px; color:#64748b;">
        Subtotal
    </div>

    <div style="font-weight:600;">
        ₱{{ number_format($invoice->subtotal, 2) }}
    </div>
</div>

<div>
    <div style="font-size:13px; color:#64748b;">
        Discount
    </div>

    <div style="font-weight:600; color:#16a34a;">

        @if($invoice->discount_type === 'percent')

            {{ rtrim(rtrim(number_format($invoice->discount_value, 2), '0'), '.') }}%
            (
            ₱{{ number_format($invoice->discount_amount, 2) }}
            )

        @elseif($invoice->discount_type === 'fixed')

            ₱{{ number_format($invoice->discount_amount, 2) }}

        @else

            ₱0.00

        @endif

    </div>
</div>

<div>
    <div style="font-size:13px; color:#64748b;">
        Final Total
    </div>

    <div style="font-weight:700;">
        ₱{{ number_format($invoice->total, 2) }}
    </div>
</div>
            <div>
                <div style="font-size:13px; color:#64748b;">
                    Paid Amount
                </div>

                <div style="font-weight:600;">
                    ₱{{ number_format($invoice->paid_amount, 2) }}
                </div>
            </div>

            <div>
                <div style="font-size:13px; color:#64748b;">
                    Remaining Balance
                </div>

                <div style="
                    font-weight:700;
                    color:#dc2626;
                ">
                    ₱{{ number_format($invoice->balance, 2) }}
                </div>
            </div>

            <div>

                @if($invoice->canBeVoided())

    <form
    method="POST"
    action="{{ route('invoices.void', $invoice) }}"
    style="display:inline;"
    onsubmit="
        const reason = prompt('Reason for voiding this invoice:');
        if (reason === null) return false;
        this.querySelector('.void-reason').value = reason;
    "
>
    @csrf

    <input
        type="hidden"
        name="void_reason"
        class="void-reason"
    >

    <button
        type="submit"
        class="btn btn-danger"
    >
        Void Invoice
    </button>

</form>

@endif
            </div>

        </div>

    </div>

</div> {{-- end invoice-print-area --}}





    {{-- ===================================================== --}}
    {{-- INVOICE ITEMS --}}
    {{-- ===================================================== --}}
 




    {{-- ===================================================== --}}
    {{-- PAYMENT SECTION PLACEHOLDER --}}
    {{-- ===================================================== --}}
    <div class="card">

        <h3 style="margin-top:0;">
            Payments
        </h3>


            <div style="margin-top:30px; border-top:1px solid #e2e8f0; padding-top:20px;">

                <h3>Payment Instructions</h3>

                {{-- CASH --}}
                @if(in_array('cash', $clinic->enabled_payment_methods ?? []))
                    <p><strong>Cash:</strong> Pay directly at the clinic.</p>
                @endif

                {{-- GCASH --}}
                @if(in_array('gcash', $clinic->enabled_payment_methods ?? []))
                    <div style="margin-bottom:15px;">
                        <strong>GCash Payment</strong><br>

                        @if($clinic->gcash_qr_path)
                            <img src="{{ asset('storage/' . $clinic->gcash_qr_path) }}"
                                 style="width:160px; margin-top:10px;">
                        @endif
                    </div>
                @endif

                {{-- MAYA --}}
                @if(in_array('maya', $clinic->enabled_payment_methods ?? []))
                    <div style="margin-bottom:15px;">
                        <strong>Maya Payment</strong><br>

                        @if($clinic->maya_qr_path)
                            <img src="{{ asset('storage/' . $clinic->maya_qr_path) }}"
                                 style="width:160px; margin-top:10px;">
                        @endif
                    </div>
                @endif

                {{-- BANK --}}
                @if(in_array('bank', $clinic->enabled_payment_methods ?? []))
                    <div>
                        <strong>Bank Transfer</strong><br>
                        {{ $clinic->bank_name }}<br>
                        {{ $clinic->bank_account_name }}<br>
                        {{ $clinic->bank_account_number }}
                    </div>
                @endif

            </div>



<form method="POST" action="{{ route('payments.store', $invoice) }}">
    @csrf



    <div style="margin-bottom:10px;">
    <label style="font-weight:600;">Payment Method</label>

    <select name="method" class="form-input" required>
        <option value="cash">Cash</option>

        @if(in_array('gcash', $clinic->enabled_payment_methods ?? []))
            <option value="gcash">GCash</option>
        @endif

        @if(in_array('maya', $clinic->enabled_payment_methods ?? []))
            <option value="maya">Maya</option>
        @endif

        @if(in_array('bank', $clinic->enabled_payment_methods ?? []))
            <option value="bank">Bank Transfer</option>
        @endif
    </select>
</div>



    <div style="margin-bottom:10px;">
        <label style="font-weight:600;">Payment Amount</label>
        <input type="number"
               name="amount"
               class="form-input"
               placeholder="Enter payment amount"
               step="0.01"
               required>
    </div>

  
    </div>

    <div style="margin-bottom:10px;">
        <label style="font-weight:600;">Notes</label>
        <textarea name="notes"
                  class="form-input"
                  placeholder="Optional notes"></textarea>
    </div>

    <button class="btn btn-primary">
        + Add Payment
    </button>
</form>

    </div>

</div>
<style>
@media print {

    body * {
        visibility: hidden;
    }

    #invoice-print-area,
    #invoice-print-area * {
        visibility: visible;
    }

    #invoice-print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .btn,
    form,
    nav,
    header,
    aside {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

@endsection