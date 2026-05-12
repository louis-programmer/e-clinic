{{-- ===================================================== --}}
{{-- FORMS MODULE --}}
{{-- Prototype UI Only (No Backend Yet) --}}
{{-- ===================================================== --}}

{{-- ===================================================== --}}
{{-- CREATE / UPLOAD FORM --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    ">

        <div>
            <h3 style="margin:0;">
                Patient Forms
            </h3>

            <div style="
                color:#64748b;
                font-size:13px;
                margin-top:4px;
            ">
                Upload and organize patient-related documents
            </div>
        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- FORM --}}
    {{-- ===================================================== --}}
    <form>

        {{-- FORM TITLE --}}
        <div style="margin-bottom:16px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Form Title
            </label>

            <input type="text"
                   class="form-input"
                   placeholder="Consent Form">

        </div>





        {{-- FORM TYPE --}}
        <div style="margin-bottom:16px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Category
            </label>

            <select class="form-input">

                <option>Consent Form</option>
                <option>Medical Clearance</option>
                <option>X-Ray</option>
                <option>Lab Result</option>
                <option>Prescription</option>
                <option>Referral</option>
                <option>Insurance</option>
                <option>Other</option>

            </select>

        </div>





        {{-- REMARKS --}}
        <div style="margin-bottom:16px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Remarks
            </label>

            <textarea class="form-input"
                      rows="3"
                      placeholder="Additional notes..."></textarea>

        </div>





        {{-- FILE --}}
        <div style="margin-bottom:20px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Upload File / Image
            </label>

            <input type="file"
                   class="form-input">

        </div>





        {{-- ACTION --}}
        <button type="button"
                class="btn btn-primary">

            + Save Form

        </button>

    </form>

</div>









{{-- ===================================================== --}}
{{-- STORED FORMS --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:10px;
    ">

        <h3 style="margin:0;">
            Uploaded Forms
        </h3>

        <div style="
            font-size:13px;
            color:#64748b;
        ">
            Prototype Preview
        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- FORM ITEM --}}
    {{-- ===================================================== --}}
    @for($i = 1; $i <= 3; $i++)

        <div style="
            background:#f8fafc;
            border-radius:10px;
            padding:18px;
            margin-bottom:16px;
            border-left:4px solid #3b82f6;
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:flex-start;
                gap:20px;
                flex-wrap:wrap;
                margin-bottom:14px;
            ">

                <div>

                    <div style="
                        font-size:12px;
                        color:#64748b;
                        margin-bottom:6px;
                    ">
                        Uploaded: {{ now()->format('M d, Y') }}
                    </div>

                    <div style="
                        font-size:17px;
                        font-weight:600;
                        margin-bottom:6px;
                    ">
                        Consent Form
                    </div>

                    <div style="
                        font-size:13px;
                        color:#64748b;
                    ">
                        Category: Medical Document
                    </div>

                </div>





                {{-- ACTIONS --}}
                <div style="
                    display:flex;
                    gap:8px;
                    flex-wrap:wrap;
                ">

                    <button class="btn btn-sm">
                        View
                    </button>

                    <button class="btn btn-sm"
                            style="background:#dc2626;color:white;">
                        Delete
                    </button>

                </div>

            </div>





            {{-- REMARKS --}}
            <div style="
                color:#334155;
                line-height:1.6;
            ">

                <strong>Remarks:</strong><br>

                Uploaded patient consent form prototype.

            </div>

        </div>

    @endfor

</div>