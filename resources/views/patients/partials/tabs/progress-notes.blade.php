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

@foreach($procedures as $category => $categoryProcedures)

    {{-- CATEGORY HEADER --}}
    <div style="
        margin-top:18px;
        margin-bottom:10px;
        font-weight:700;
        font-size:15px;
        color:#0f172a;
        border-bottom:1px solid #e2e8f0;
        padding-bottom:6px;
    ">
        {{ ucfirst($category) }}
    </div>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
        gap:8px;
    ">

        @foreach($categoryProcedures as $procedure)

            <label style="
                display:flex;
                align-items:center;
                justify-content:space-between;
                gap:10px;
                padding:8px 10px;
                border:1px solid #e2e8f0;
                border-radius:8px;
                background:white;
                cursor:pointer;
            ">

                <div style="
                    min-width:0;
                    flex:1;
                ">

                    <div style="
                        font-size:14px;
                        font-weight:600;
                        color:#0f172a;
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                    ">
                        {{ $procedure->name }}
                    </div>

                   @if(!config('procedures.manual_price_enabled'))

                        <div style="
                            font-size:12px;
                            color:#64748b;
                        ">
                           @if(!config('procedures.manual_price_enabled'))
                                ₱{{ number_format($procedure->price, 2) }}
                            @else
                                <span style="color:#94a3b8;">Override enabled</span>
                            @endif
                        </div>

                    @endif

                </div>

                         <div style="
                                display:flex;
                                align-items:center;
                                gap:8px;
                            ">

                               <input type="checkbox"
                                    class="procedure-checkbox"
                                    data-id="{{ $procedure->id }}"
                                    data-price="{{ $procedure->price }}"
                                    name="procedures[]"
                                    value="{{ $procedure->id }}">

                                @if(config('procedures.manual_price_enabled'))

                                    <input type="number"
                                           name="custom_prices[{{ $procedure->id }}]"
                                           class="form-input"
                                           placeholder="Override"
                                           step="0.01"
                                           min="0"
                                           style="
                                                width:110px;
                                                margin:0;
                                           ">

                                @endif

                            </div>
                                                   


            </label>

        @endforeach

    </div>

@endforeach

        </div>

<div id="custom-procedures-container"
     style="
        margin-top:20px;
        padding:12px;
        border:1px dashed #cbd5e1;
        border-radius:8px;
     ">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <div style="font-weight:600;">
            Others (Manual Procedures)
        </div>

        <button type="button"
                id="add-custom-procedure-btn"
                style="
                    padding:6px 10px;
                    font-size:12px;
                    border:1px solid #cbd5e1;
                    background:white;
                    border-radius:6px;
                    cursor:pointer;
                ">
            + Add Another
        </button>
    </div>

    <div id="custom-rows">

        <div class="custom-row" style="margin-bottom:10px;">

            <input type="text"
                   name="custom_procedure_name[]"
                   class="form-input"
                   placeholder="Procedure name">

            <input type="number"
                   name="custom_procedure_price[]"
                   class="form-input custom-price"
                   placeholder="Price"
                   step="0.01"
                   min="0"
                   style="margin-top:6px;">

        </div>

    </div>

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
{{-- DISCOUNT --}}
{{-- ===================================================== --}}
<div style="margin-bottom:14px;">

    <label style="
        display:block;
        margin-bottom:6px;
        font-weight:600;
    ">
        Discount Type
    </label>

            <select
            name="discount_type"
            id="discount-type" class="form-input">

        <option value="">
            No Discount
        </option>

        <option value="percent">
            Percent (%)
        </option>

        <option value="fixed">
            Fixed Amount (₱)
        </option>

    </select>

</div>

<div style="margin-bottom:20px;">

    <label style="
        display:block;
        margin-bottom:6px;
        font-weight:600;
    ">
        Discount Value
    </label>

           <input
            type="number"
            name="discount_value"
            id="discount-value"
                class="form-input"
                placeholder="Enter discount"
                min="0"
                step="0.01"
            >

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
                Estimated Total:
                <span id="checkout-total">₱0.00</span>

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
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // ELEMENTS
    // =====================================================
    const checkboxes = document.querySelectorAll('.procedure-checkbox');
    const totalDisplay = document.getElementById('checkout-total');

    const discountType = document.getElementById('discount-type');
    const discountValue = document.getElementById('discount-value');

    const addBtn = document.getElementById('add-custom-procedure-btn');
    const customContainer = document.getElementById('custom-rows');

    // =====================================================
    // CORE TOTAL ENGINE
    // =====================================================
    function updateCheckoutTotal() {

        let subtotal = 0;

        // -------------------------------------------------
        // PROCEDURES
        // -------------------------------------------------
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const manualEnabled = @json(config('procedures.manual_price_enabled'));

                    checkboxes.forEach(cb => {

                        if (!cb.checked) return;

                        const id = cb.dataset.id;

                        let price = parseFloat(cb.dataset.price) || 0;

                        // -------------------------------------------------
                        // OVERRIDE MODE
                        // -------------------------------------------------
                        if (manualEnabled) {

                            const overrideInput = document.querySelector(
                                `input[name="custom_prices[${id}]"]`
                            );

                            if (overrideInput && overrideInput.value !== '') {
                                price = parseFloat(overrideInput.value) || 0;
                            }
                        }

                        subtotal += price;
                    });
            }
        });

        // -------------------------------------------------
        // CUSTOM PROCEDURES (MULTIPLE ROWS)
        // -------------------------------------------------
        const customPrices = document.querySelectorAll('.custom-price');

        customPrices.forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        // -------------------------------------------------
        // DISCOUNT
        // -------------------------------------------------
        let total = subtotal;

        const type = discountType.value;
        const value = parseFloat(discountValue.value) || 0;

        if (type === 'percent') {
            total -= (subtotal * value / 100);
        }

        if (type === 'fixed') {
            total -= value;
        }

        if (total < 0) total = 0;

        // -------------------------------------------------
        // OUTPUT
        // -------------------------------------------------
        totalDisplay.innerText = '₱' + total.toFixed(2);
    }

    // =====================================================
    // PROCEDURE EVENTS
    // =====================================================
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCheckoutTotal);
    });

    // =====================================================
    // DISCOUNT EVENTS
    // =====================================================
    discountType.addEventListener('change', updateCheckoutTotal);
    discountValue.addEventListener('input', updateCheckoutTotal);

    // =====================================================
    // CUSTOM ROW EVENTS (LIVE)
    // =====================================================
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('custom-price')) {
            updateCheckoutTotal();
        }
    });

    // =====================================================
    // ADD NEW CUSTOM ROW
    // =====================================================
    if (addBtn) {
        addBtn.addEventListener('click', function () {

            const row = document.createElement('div');
            row.classList.add('custom-row');
            row.style.marginBottom = '10px';

            row.innerHTML = `
                <input type="text"
                       name="custom_procedure_name[]"
                       class="form-input"
                       placeholder="Procedure name">

                <input type="number"
                       name="custom_procedure_price[]"
                       class="form-input custom-price"
                       placeholder="Price"
                       step="0.01"
                       min="0"
                       style="margin-top:6px;">

                <button type="button"
                        class="remove-row"
                        style="
                            margin-top:6px;
                            padding:4px 8px;
                            font-size:11px;
                            border:1px solid #ef4444;
                            background:white;
                            color:#ef4444;
                            border-radius:6px;
                            cursor:pointer;
                        ">
                    Remove
                </button>
            `;

            customContainer.appendChild(row);

            // remove handler
            row.querySelector('.remove-row').addEventListener('click', function () {
                row.remove();
                updateCheckoutTotal();
            });

        });
    }

    // =====================================================
    // INITIAL CALC
    // =====================================================
    updateCheckoutTotal();

});
</script>


<script>
document.querySelector('form').addEventListener('submit', function (e) {

    const rows = document.querySelectorAll('.custom-row');

    let hasError = false;

    rows.forEach(row => {

        const nameInput = row.querySelector('input[name="custom_procedure_name[]"]');
        const priceInput = row.querySelector('input[name="custom_procedure_price[]"]');

        const name = nameInput.value.trim();
        const price = parseFloat(priceInput.value);

        // If price exists but no name → BLOCK
        if ((priceInput.value !== '' && !isNaN(price) && price > 0) && name === '') {
            hasError = true;

            nameInput.style.border = "2px solid #ef4444";
            nameInput.placeholder = "⚠ Required if price is set";
        }
    });

    if (hasError) {
        e.preventDefault();
        alert("Please name all 'Others' procedures before continuing.");
    }
});
</script>