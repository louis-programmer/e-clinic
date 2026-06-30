
{{-- ===================================================== --}}
{{-- HISTORY (PROGRESS + BILLING SOURCE) --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3 style="margin-top:0;">
        Progress & Checkout History
    </h3>

    {{ $invoices->links('pagination::simple-default') }}

@forelse($invoices as $invoice)

    <div style="
        border:1px solid #e2e8f0;
        border-radius:10px;
        padding:16px;
        margin-bottom:14px;
        background:white;
    ">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}
        <div style="
            display:flex;
            justify-content:space-between;
            margin-bottom:12px;
            flex-wrap:wrap;
            gap:10px;
        ">

            <div>

 <div style="font-weight:700;">

    <a href="{{ route('invoices.show', $invoice) }}"
       style="
            text-decoration:none;
            color:#2563eb;
       ">

        {{ $invoice->invoice_number }}

    </a>

</div>
                <div style="
                    font-size:13px;
                    color:#64748b;
                ">
                    Status:
                    {{ ucfirst($invoice->status) }}
                </div>

            </div>

            <div style="
                text-align:right;
                font-size:13px;
                color:#64748b;
            ">

                <div>
                    {{ $invoice->created_at->format('M d, Y h:i A') }}
                </div>

                <div style="
                    margin-top:4px;
                    font-weight:600;
                    color:#0f172a;
                ">
                    Total:
                    ₱{{ number_format($invoice->total, 2) }}
                </div>

            </div>

        </div>

        {{-- ===================================================== --}}
        {{-- ITEMS --}}
        {{-- ===================================================== --}}
        <div style="
            border-top:1px solid #e2e8f0;
            padding-top:12px;
        ">

            @foreach($invoice->items as $item)

                <div style="
                    display:flex;
                    justify-content:space-between;
                    margin-bottom:8px;
                    font-size:14px;
                ">

                    <div>
                        {{ $item->description }}
                    </div>

                    <div>
                        ₱{{ number_format($item->line_total, 2) }}
                    </div>

                </div>

            @endforeach

        </div>

        {{-- ===================================================== --}}
        {{-- FOOTER --}}
        {{-- ===================================================== --}}
        <div style="
            border-top:1px solid #e2e8f0;
            margin-top:12px;
            padding-top:12px;
            display:flex;
            justify-content:space-between;
            flex-wrap:wrap;
            gap:10px;
            font-size:14px;
        ">

            <div>
                Balance:
                <strong>
                    ₱{{ number_format($invoice->balance, 2) }}
                </strong>
            </div>

            <div>
                Paid:
                <strong>
                    ₱{{ number_format($invoice->paid_amount, 2) }}
                </strong>
            </div>

        </div>

    </div>

@empty

    <div style="
        background:#f8fafc;
        border-radius:10px;
        padding:30px;
        text-align:center;
        color:#64748b;
    ">
        No checkout records yet.
    </div>

@endforelse

{{ $invoices->links('pagination::simple-default') }}
</div>