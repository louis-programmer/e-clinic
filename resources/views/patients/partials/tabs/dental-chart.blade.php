{{-- ===================================================== --}}
{{-- DENTAL CHART (SURFACE-BASED ODONTOGRAM) --}}
{{-- ===================================================== --}}

<div class="card">

    <h3 style="margin-bottom:15px;">Dental Chart</h3>

    {{-- SELECTED --}}
    <div style="background:#f8fafc;padding:12px;border-radius:10px;margin-bottom:15px;">
        <strong>Selected:</strong>
        <div id="selected-tooth" style="color:#2563eb;font-weight:600;">
            None
        </div>
    </div>

    {{-- NOTES --}}
    <div style="margin-bottom:20px;">

        <label style="font-weight:600;display:block;margin-bottom:6px;">
            Surface Remarks
        </label>

        <div style="margin-bottom:10px;">
            <label style="font-weight:600;">Condition</label>

            <select id="condition-select" class="form-input">
                <option value="">None</option>
                <option value="healthy">Healthy</option>
                <option value="decay">Decay</option>
                <option value="filling">Filling</option>
                <option value="crown">Crown</option>
                <option value="missing">Missing</option>
                <option value="extraction">Extraction</option>
                <option value="sealant">Sealant</option>
            </select>
        </div>

        <textarea id="tooth-note"
                  class="form-input"
                  rows="4"
                  disabled
                  placeholder="Select a surface first..."></textarea>

        <button id="save-note" class="btn btn-primary" disabled style="margin-top:10px;">
            Save Note
        </button>

    </div>

    {{-- TOOTH GRID --}}
    @php
        $upperRight = [18,17,16,15,14,13,12,11];
        $upperLeft  = [21,22,23,24,25,26,27,28];
        $lowerRight = [48,47,46,45,44,43,42,41];
        $lowerLeft  = [31,32,33,34,35,36,37,38];

        $primaryUpperRight = [55,54,53,52,51];
        $primaryUpperLeft  = [61,62,63,64,65];
        $primaryLowerRight = [85,84,83,82,81];
        $primaryLowerLeft  = [71,72,73,74,75];

        $surfaces = ['top','left','center','right','bottom'];
    @endphp

    @foreach([
        ['label' => 'Upper Jaw', 'left' => $upperRight, 'right' => $upperLeft],
        ['label' => 'Lower Jaw', 'left' => $lowerRight, 'right' => $lowerLeft],
    ] as $row)

        <div style="text-align:center;font-weight:700;margin:15px 0;">
            {{ $row['label'] }}
        </div>

        <div style="display:flex;justify-content:center;gap:25px;margin-bottom:25px;flex-wrap:wrap;">

            <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
                @foreach($row['left'] as $tooth)
                    @include('patients.partials.tooth', compact('tooth', 'surfaces'))
                @endforeach
            </div>

            <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
                @foreach($row['right'] as $tooth)
                    @include('patients.partials.tooth', compact('tooth', 'surfaces'))
                @endforeach
            </div>

        </div>

    @endforeach

    <div style="text-align:center;font-weight:700;margin:15px 0;">
        Pediatric Teeth
    </div>

    <div style="display:flex;justify-content:center;gap:25px;flex-wrap:wrap;">

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
            @foreach($primaryUpperRight as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
            @foreach($primaryUpperLeft as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

    </div>

    <div style="height:15px;"></div>

    <div style="display:flex;justify-content:center;gap:25px;flex-wrap:wrap;">

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
            @foreach($primaryLowerRight as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;">
            @foreach($primaryLowerLeft as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

    </div>
</div>

{{-- ===================================================== --}}
{{-- STYLES --}}
{{-- ===================================================== --}}
<style>
.tooth-wrapper { display:flex; flex-direction:column; align-items:center; }
.tooth-number { font-size:11px; font-weight:700; margin-bottom:4px; }

.tooth-grid {
    width:54px;
    height:54px;
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    grid-template-rows:repeat(3, 1fr);
    gap:2px;
}

.surface {
    background:#e2e8f0;
    border-radius:3px;
    cursor:pointer;
}

.top { grid-column:2; grid-row:1; }
.left { grid-column:1; grid-row:2; }
.center { grid-column:2; grid-row:2; background:#94a3b8; }
.right { grid-column:3; grid-row:2; }
.bottom { grid-column:2; grid-row:3; }

.surface:hover { background:#cbd5e1; }
.surface.active { background:#2563eb; }

.surface.decay { background:#ef4444; }
.surface.filling { background:#3b82f6; }
.surface.crown { background:#f59e0b; }
.surface.missing,
.surface.extraction { background:#111827; }
.surface.sealant { background:#10b981; }
.surface.healthy { background:#22c55e; }
</style>

{{-- ===================================================== --}}
{{-- SCRIPT --}}
{{-- ===================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dentalRecords = @json($records);
    const toothStates = @json($toothStates);

    const display = document.getElementById('selected-tooth');
    const noteBox = document.getElementById('tooth-note');
    const saveBtn = document.getElementById('save-note');
    const conditionSelect = document.getElementById('condition-select');

    let activeTooth = null;
    let activeSide = null;
    let activeSurfaceElement = null;

    // =====================================
    // APPLY EXISTING DATA (FIXED)
    // =====================================
function applyInitialState() {

    dentalRecords.forEach(record => {

        if (!record.tooth_number || !record.surface || !record.condition) return;

        const selector = `.surface[data-tooth="${record.tooth_number}"][data-side="${record.surface}"]`;

        const surface = document.querySelector(selector);

        if (!surface) {
            console.warn("Missing surface:", selector);
            return;
        }

        surface.classList.add(record.condition);
    });
}

window.requestAnimationFrame(() => {
    applyInitialState();
});

    // =====================================
    // CLICK HANDLER
    // =====================================
    document.addEventListener('click', function (e) {

        const surface = e.target.closest('.surface');
        if (!surface) return;

        document.querySelectorAll('.surface').forEach(s =>
            s.classList.remove('active')
        );

        surface.classList.add('active');

        activeSurfaceElement = surface;
        activeTooth = surface.dataset.tooth;
        activeSide = surface.dataset.side;

        display.innerText = `Tooth ${activeTooth} - ${activeSide}`;

        const existing = dentalRecords.find(r =>
            r.tooth_number == activeTooth &&
            r.surface == activeSide
        );

        noteBox.disabled = false;
        saveBtn.disabled = false;

        noteBox.value = existing ? existing.remarks : '';
       conditionSelect.value = existing?.condition || ''; // ✅ HERE
    });

    // =====================================
    // SAVE
    // =====================================
    saveBtn.addEventListener('click', async function () {

        if (!activeSurfaceElement) {
            return alert("Select a surface first.");
        }

        const formData = new FormData();
        formData.append('tooth_number', activeTooth);
        formData.append('surface', activeSide);
        formData.append('remark', noteBox.value);
        formData.append('condition', conditionSelect.value);
        formData.append('_token', '{{ csrf_token() }}');

        const res = await fetch("{{ route('dental-chart.store', $patient->id) }}", {
            method: "POST",
            body: formData
        });

        if (res.ok) {

            activeSurfaceElement.classList.remove(
                'healthy','decay','filling','crown',
                'missing','extraction','sealant'
            );

            if (conditionSelect.value) {
                activeSurfaceElement.classList.add(conditionSelect.value);
            }

            // update local cache (IMPORTANT FIX)
            const existing = dentalRecords.find(r =>
                r.tooth_number == activeTooth &&
                r.surface == activeSide
            );

           if (existing) {

                existing.condition = conditionSelect.value;
                existing.remarks = noteBox.value;

            } else {

                dentalRecords.push({
                    tooth_number: activeTooth,
                    surface: activeSide,
                    condition: conditionSelect.value,
                    remarks: noteBox.value
                });
            }

            alert("Saved!");
        }
    });

});
</script>