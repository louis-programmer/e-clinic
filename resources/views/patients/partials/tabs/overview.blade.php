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
{{-- CONDITIONS --}}
{{-- ============================================= --}}
<div style="margin-bottom:20px;">

    <label style="
        display:block;
        margin-bottom:10px;
        font-weight:600;
    ">
        Medical Conditions
    </label>

    @php
        $conditions = [
            'Hypertension',
            'Diabetes',
            'Asthma',
            'Heart Disease',
            'Tuberculosis',
            'Arthritis',
            'Allergies',
            'Cancer',
            'Kidney Disease',
            'Liver Disease',
            'Thyroid Disorder',
            'Migraine',
            'Epilepsy',
            'Depression',
            'Anxiety',
            'Stroke',
            'COPD',
            'Pneumonia',
            'Anemia',
            'High Cholesterol',
        ];
    @endphp

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
        gap:10px;
    ">

        @foreach($conditions as $condition)

            <label style="
                display:flex;
                align-items:center;
                gap:8px;
                padding:10px;
                border:1px solid #e2e8f0;
                border-radius:8px;
                background:white;
                cursor:pointer;
            ">

                <input type="checkbox"
                       name="conditions[]"
                       value="{{ $condition }}">

                <span>{{ $condition }}</span>

            </label>

        @endforeach

    </div>

</div>





{{-- ============================================= --}}
{{-- OTHER CONDITION --}}
{{-- ============================================= --}}
<div style="margin-bottom:20px;">

    <label style="
        display:flex;
        align-items:center;
        gap:8px;
        margin-bottom:10px;
        font-weight:600;
    ">

        <input type="checkbox"
               id="other-condition-checkbox">

        Other Condition

    </label>

    <input type="text"
           name="other_condition"
           id="other-condition-input"
           class="form-input"
           placeholder="Enter other condition..."
           style="display:none;">

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


<script>
const checkbox = document.getElementById('other-condition-checkbox');
const input = document.getElementById('other-condition-input');

checkbox.addEventListener('change', () => {
    input.style.display = checkbox.checked ? 'block' : 'none';

    if (!checkbox.checked) {
        input.value = '';
    }
});
</script>

</div>