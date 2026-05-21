{{-- ===================================================== --}}
{{-- PROCEDURE CHECKOUT / PROGRESS NOTE --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">
        <h3 style="margin:0;">
            Procedure Checkout / Progress Note
        </h3>
    </div>

    <form method="POST" action="{{ route('checkout.store', $patient) }}">
        @csrf

        {{-- ===================================================== --}}
        {{-- PROCEDURES (CHECKOUT SELECTION) --}}
        {{-- ===================================================== --}}
        <div style="margin-bottom:14px;">

            <label style="
                display:block;
                margin-bottom:10px;
                font-weight:600;
            ">
                Select Procedures
            </label>

            @foreach($procedures as $procedure)

                <label style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:8px;
                    padding:10px;
                    border:1px solid #e2e8f0;
                    border-radius:8px;
                    background:white;
                ">

                    <div>
                        <div style="font-weight:600;">
                            {{ $procedure->name }}
                        </div>

                        <div style="font-size:13px; color:#64748b;">
                            Category: {{ ucfirst($procedure->category) }}
                        </div>

                        <div style="font-size:13px; color:#64748b;">
                            ₱{{ number_format($procedure->price, 2) }}
                        </div>
                    </div>

                    <input type="checkbox"
                           name="procedures[]"
                           value="{{ $procedure->id }}">

                </label>

            @endforeach

        </div>

        {{-- ===================================================== --}}
        {{-- CATEGORY (OPTIONAL NOTE LEVEL) --}}
        {{-- ===================================================== --}}
        <div style="margin-bottom:14px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Note Category
            </label>

            <select name="category"
                    class="form-input">

                <option value="">Select Category</option>
                <option value="preventive">Preventive</option>
                <option value="restorative">Restorative</option>
                <option value="surgical">Surgical</option>
                <option value="cosmetic">Cosmetic</option>

            </select>

        </div>

        {{-- ===================================================== --}}
        {{-- REMARKS --}}
        {{-- ===================================================== --}}
        <div style="margin-bottom:14px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Remarks
            </label>

            <textarea name="remarks"
                      rows="4"
                      class="form-input"
                      placeholder="Enter clinical notes or procedure remarks..."></textarea>

        </div>

        {{-- ===================================================== --}}
        {{-- CHECKOUT SUMMARY (PLACEHOLDER) --}}
        {{-- ===================================================== --}}
        <div style="
            background:#f8fafc;
            border-radius:10px;
            padding:16px;
            margin-bottom:20px;
        ">

            <div style="
                font-weight:600;
                margin-bottom:10px;
            ">
                Checkout Summary
            </div>

            <div style="
                color:#64748b;
                font-size:14px;
                line-height:1.6;
            ">
                Selected procedures will be computed into an invoice in the next step.
            </div>

            <div style="
                margin-top:10px;
                font-weight:600;
            ">
                Estimated Total: ₱0.00
                <small style="color:#64748b;">(to be computed)</small>
            </div>

        </div>

        {{-- ===================================================== --}}
        {{-- SUBMIT --}}
        {{-- ===================================================== --}}
        <button class="btn btn-primary">
            + Create Checkout Entry
        </button>

    </form>

</div>





{{-- ===================================================== --}}
{{-- HISTORY (PROGRESS + BILLING SOURCE) --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3 style="margin-top:0;">
        Progress & Checkout History
    </h3>

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
</div>