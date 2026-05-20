{{-- ===================================================== --}}
{{-- PROGRESS NOTE --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">
        <h3 style="margin:0;">
            Patient Progress Notes
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
                margin-bottom:10px;
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

                        {{ $procedure->name }}
                        —
                        ₱{{ number_format($procedure->price, 2) }}

                    </option>

                @endforeach

            </select>

            @error('procedure_id')
                <div style="
                    color:red;
                    font-size:13px;
                    margin-top:5px;
                ">
                    {{ $message }}
                </div>
            @enderror

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

            <textarea
                name="remarks"
                rows="4"
                class="form-input"
                placeholder="Enter clinical findings, treatment notes, observations, or follow-up instructions..."
            >{{ old('remarks') }}</textarea>

            @error('remarks')
                <div style="
                    color:red;
                    font-size:13px;
                    margin-top:5px;
                ">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- ===================================================== --}}
        {{-- NOTE INFO --}}
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
                Progress Note Information
            </div>

            <div style="
                color:#64748b;
                font-size:14px;
                line-height:1.6;
            ">
                This saves directly into the dedicated patient progress notes table
                and is separate from the billing / checkout system.
            </div>

        </div>

        {{-- ===================================================== --}}
        {{-- SUBMIT --}}
        {{-- ===================================================== --}}
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
                flex-wrap:wrap;
                gap:10px;
            ">

                <div>

                    <div style="font-weight:600;">
                        {{ $note->procedure?->name ?? 'Unknown Procedure' }}
                    </div>

                    <div style="
                        font-size:13px;
                        color:#64748b;
                    ">
                        {{ ucfirst($note->procedure?->category ?? 'uncategorized') }}
                    </div>

                </div>

                <div style="
                    font-size:13px;
                    color:#64748b;
                ">
                    {{ $note->created_at->format('M d, Y h:i A') }}
                </div>

            </div>

            @if($note->remarks)

                <div style="
                    color:#334155;
                    line-height:1.6;
                    white-space:pre-line;
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