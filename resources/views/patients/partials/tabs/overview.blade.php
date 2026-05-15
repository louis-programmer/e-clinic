<div class="card">

    <h3>Medical History</h3>

    <p style="color:#64748b;">
        Record of patient medical conditions and history.
    </p>

</div>





{{-- ===================================================== --}}
{{-- ADD CONDITION --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3>Add Medical Condition</h3>

    <form method="POST"
          action="{{ route('medical-history.store', $patient->id) }}">

        @csrf

        {{-- ============================================= --}}
        {{-- CONDITION DROPDOWN --}}
        {{-- ============================================= --}}
        <div style="margin-bottom:20px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Medical Condition
            </label>

            <select name="condition_name"
                    class="form-input">

                <option value="">
                    -- Select Condition --
                </option>

                <option value="Hypertension">Hypertension</option>
                <option value="Diabetes">Diabetes</option>
                <option value="Asthma">Asthma</option>
                <option value="Heart Disease">Heart Disease</option>
                <option value="Tuberculosis">Tuberculosis</option>
                <option value="Arthritis">Arthritis</option>
                <option value="Allergies">Allergies</option>
                <option value="Cancer">Cancer</option>
                <option value="Kidney Disease">Kidney Disease</option>
                <option value="Liver Disease">Liver Disease</option>
                <option value="Thyroid Disorder">Thyroid Disorder</option>
                <option value="Migraine">Migraine</option>
                <option value="Epilepsy">Epilepsy</option>
                <option value="Depression">Depression</option>
                <option value="Anxiety">Anxiety</option>
                <option value="Stroke">Stroke</option>
                <option value="COPD">COPD</option>
                <option value="Pneumonia">Pneumonia</option>
                <option value="Anemia">Anemia</option>
                <option value="High Cholesterol">High Cholesterol</option>

            </select>

        </div>







        {{-- ============================================= --}}
        {{-- STATUS --}}
        {{-- ============================================= --}}
        <div style="margin-bottom:20px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Status
            </label>

            <select name="status"
                    class="form-input"
                    required>

                <option value="active">Active</option>
                <option value="resolved">Resolved</option>
                <option value="chronic">Chronic</option>

            </select>

        </div>





        {{-- ============================================= --}}
        {{-- NOTES --}}
        {{-- ============================================= --}}
        <div style="margin-bottom:20px;">

            <label style="
                display:block;
                margin-bottom:6px;
                font-weight:600;
            ">
                Notes
            </label>

            <textarea name="notes"
                      class="form-input"
                      rows="3"
                      placeholder="Additional notes..."></textarea>

        </div>





        {{-- ============================================= --}}
        {{-- SUBMIT --}}
        {{-- ============================================= --}}
        <button class="btn btn-primary">

            Add Condition

        </button>

    </form>

</div>





{{-- ===================================================== --}}
{{-- LIST --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3>Conditions</h3>

    @forelse($patient->medicalHistories as $history)

        <div style="
            padding:15px;
            border:1px solid #e2e8f0;
            border-radius:10px;
            margin-bottom:12px;
            background:#f8fafc;
        ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:flex-start;
                gap:20px;
                flex-wrap:wrap;
            ">

                <div>

                    <div style="
                        font-size:17px;
                        font-weight:600;
                        margin-bottom:6px;
                    ">
                        {{ $history->condition_name }}
                    </div>

                    <div style="
                        font-size:13px;
                        color:#64748b;
                        margin-bottom:10px;
                    ">
                        Status:
                        <strong>{{ ucfirst($history->status) }}</strong>
                    </div>

                    @if($history->notes)

                        <div style="
                            color:#334155;
                            line-height:1.6;
                        ">
                            {{ $history->notes }}
                        </div>

                    @endif

                </div>





                {{-- DELETE --}}
                <form method="POST"
                      action="{{ route('medical-history.destroy', [$patient->id, $history->id]) }}">

                    @csrf
                    @method('DELETE')

                    <button style="
                        background:#dc2626;
                        color:white;
                        border:none;
                        padding:8px 14px;
                        border-radius:6px;
                        cursor:pointer;
                    ">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    @empty

        <p style="color:#64748b;">
            No medical history recorded yet.
        </p>

    @endforelse

</div>