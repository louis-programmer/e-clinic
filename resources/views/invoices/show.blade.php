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

<div style="
    max-width:1100px;
    margin:auto;
">

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

            <div>

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
                    Total Amount
                </div>

                <div style="font-weight:600;">
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

        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- INVOICE ITEMS --}}
    {{-- ===================================================== --}}
    <div class="card" style="margin-bottom:20px;">

        <h3 style="margin-top:0;">
            Procedures
        </h3>

        <div style="
            overflow-x:auto;
        ">

            <table style="
                width:100%;
                border-collapse:collapse;
            ">

                <thead>

                    <tr style="
                        background:#f8fafc;
                    ">

                        <th style="
                            text-align:left;
                            padding:12px;
                        ">
                            Procedure
                        </th>

                        <th style="
                            text-align:left;
                            padding:12px;
                        ">
                            Qty
                        </th>

                        <th style="
                            text-align:left;
                            padding:12px;
                        ">
                            Unit Price
                        </th>

                        <th style="
                            text-align:left;
                            padding:12px;
                        ">
                            Line Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($invoice->items as $item)

                        <tr style="
                            border-top:1px solid #e2e8f0;
                        ">

                            <td style="padding:12px;">
                                {{ $item->description }}
                            </td>

                            <td style="padding:12px;">
                                {{ $item->qty }}
                            </td>

                            <td style="padding:12px;">
                                ₱{{ number_format($item->unit_price, 2) }}
                            </td>

                            <td style="
                                padding:12px;
                                font-weight:600;
                            ">
                                ₱{{ number_format($item->line_total, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- PAYMENT SECTION PLACEHOLDER --}}
    {{-- ===================================================== --}}
    <div class="card">

        <h3 style="margin-top:0;">
            Payments
        </h3>

        <form method="POST" action="{{ route('payments.store', $invoice) }}">
    @csrf

    <div style="margin-bottom:10px;">
        <label style="font-weight:600;">Payment Amount</label>
        <input type="number"
               name="amount"
               class="form-input"
               placeholder="Enter payment amount"
               step="0.01"
               required>
    </div>

    <div style="margin-bottom:10px;">
        <label style="font-weight:600;">Payment Method</label>
        <input type="text"
               name="method"
               class="form-input"
               placeholder="cash / gcash / card">
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

@endsection