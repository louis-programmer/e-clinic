{{-- ===================================================== --}}
{{-- CREATE PROGRESS NOTE --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">
        <h3 style="margin:0;">
            Create Progress Note
        </h3>
    </div>





<form method="POST" action="{{ route('progress-notes.store', $patient) }}">
        @csrf

        {{-- ===================================================== --}}
        {{-- PROCEDURE --}}
        {{-- ===================================================== --}}
        <div style="margin-bottom:14px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Procedure
            </label>

<select name="procedure_id" class="form-input">

    <option value="">
        Select Procedure
    </option>

    @foreach($procedures as $procedure)
        <option value="{{ $procedure->id }}">
            {{ $procedure->name }} - ₱{{ $procedure->price }}
        </option>
    @endforeach

</select>

        </div>





        {{-- ===================================================== --}}
        {{-- CATEGORY --}}
        {{-- ===================================================== --}}
        <div style="margin-bottom:14px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Category
            </label>

            <select name="category"
                    class="form-input">

                <option value="">
                    Select Category
                </option>

                <option>
                    Preventive
                </option>

                <option>
                    Restorative
                </option>

                <option>
                    Surgical
                </option>

                <option>
                    Cosmetic
                </option>

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
                      placeholder="Procedure remarks..."></textarea>

        </div>





        {{-- ===================================================== --}}
        {{-- PAYMENT PLACEHOLDER --}}
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
                Payment Information
            </div>

            <div style="
                color:#64748b;
                font-size:14px;
                line-height:1.6;
            ">
                Payment workflow is still under discussion.
            </div>

        </div>





        <button class="btn btn-primary">
            + Save Progress Note
        </button>

    </form>

</div>









{{-- ===================================================== --}}
{{-- PROGRESS NOTE HISTORY --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3 style="margin-top:0;">
        Progress Note History
    </h3>

    @forelse($progressNotes as $note)

    <div style="
        border:1px solid #e2e8f0;
        border-radius:10px;
        padding:16px;
        margin-bottom:14px;
        background:white;
    ">

        <div style="
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            gap:10px;
            flex-wrap:wrap;
        ">

            <div>
                <div style="font-weight:600;">
                    {{ $note->procedure?->name ?? 'Unknown Procedure' }}
                </div>

                <div style="
                    color:#64748b;
                    font-size:13px;
                ">
                    {{ ucfirst($note->procedure?->category ?? 'uncategorized') }}
                </div>
            </div>

            <div style="
                color:#64748b;
                font-size:13px;
            ">
                {{ $note->created_at->format('M d, Y h:i A') }}
            </div>

        </div>

        @if($note->remarks)
            <div style="
                line-height:1.6;
                color:#334155;
            ">
                {{ $note->remarks }}
            </div>
        @endif

    </div>

@empty

    <div style="
        background:#f8fafc;
        border-radius:10px;
        padding:30px;
        text-align:center;
        color:#64748b;
    ">
        No progress notes yet.
    </div>

@endforelse


</div>