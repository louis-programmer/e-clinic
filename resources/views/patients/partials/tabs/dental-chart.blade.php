{{-- 
Tab for Dental chart

    Connected to:
        -DentalChartRecord.php
        -DentalChartController.php
        -PatientTooth.php
        -tooth.blade.php


        -- has own CSS

        -- chart color is within this code

    -- updated to use config file (/config)
    when searching for the olf code, find "old"
    below them are the new code for the config file
--}}

{{-- ===================================================== --}}
{{-- DENTAL CHART LEGEND --}}
{{-- ===================================================== --}}
<div class="card" style="margin-bottom:20px;">

    <h4 style="margin-top:0;margin-bottom:15px;">
        Tooth Condition Legend
    </h4>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:10px;
    ">

        @foreach(config('dental-chart.conditions') as $condition => $color)

            <div style="
                display:flex;
                align-items:center;
                gap:10px;
                padding:8px 10px;
                border:1px solid #e2e8f0;
                border-radius:8px;
                background:#fff;
            ">

                <div style="
                    width:18px;
                    height:18px;
                    border-radius:4px;
                    border:1px solid #cbd5e1;
                    background:{{ $color }};
                    flex-shrink:0;
                ">
                </div>

                <span style="
                    font-size:14px;
                    color:#0f172a;
                ">
                    {{ $condition }}
                </span>

            </div>

        @endforeach

    </div>

</div>
{{-- ===================================================== --}}
{{-- DENTAL CHART (SURFACE-BASED ODONTOGRAM) --}}
{{-- ===================================================== --}}

<div class="card">

    <h3 style="margin-bottom:15px;">Dental Chart</h3>


        <div id="tooth-editor-backdrop"
             style="
                display:none;
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.35);
                z-index:99998;
             ">
        </div>

            <div id="tooth-editor" class="tooth-editor">

                <div style="font-weight:600;margin-bottom:8px;">
                    <span id="editor-title"></span>
                </div>

                <select id="condition-select" class="form-input">
                    <option value="">None</option>
                       @foreach(config('dental-chart.conditions') as    $condition => $color)

                            <option value="{{ $condition }}">
                                {{ $condition }}
                            </option>

                        @endforeach
                </select>

                <textarea
                    id="tooth-note"
                    class="form-input"
                    rows="3"
                    placeholder="Remarks..."
                    style="margin-top:10px;"
                ></textarea>

                <button
                    id="save-note"
                    class="btn btn-primary"
                    style="margin-top:10px;"
                >
                    Save
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

{{-- ===================================================== --}}
{{-- UPPER PEDIATRIC --}}
{{-- ===================================================== --}}

<div style="display:flex;justify-content:center;gap:25px;margin-bottom:20px;flex-wrap:wrap;">

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

    {{-- ===================================================== --}}
    {{-- UPPER PERMANENT --}}
    {{-- ===================================================== --}}

    <div style="text-align:center;font-weight:700;margin:15px 0;">
        Upper Jaw
    </div>

    <div style="display:flex;justify-content:center;gap:25px;margin-bottom:25px;flex-wrap:wrap;">

        <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
            @foreach($upperRight as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
            @foreach($upperLeft as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- LOWER PERMANENT --}}
    {{-- ===================================================== --}}

    <div style="text-align:center;font-weight:700;margin:15px 0;">
        Lower Jaw
    </div>

    <div style="display:flex;justify-content:center;gap:25px;margin-bottom:25px;flex-wrap:wrap;">

        <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
            @foreach($lowerRight as $tooth)
                @include('patients.partials.tooth', compact('tooth', 'surfaces'))
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:10px;">
            @foreach($lowerLeft as $tooth)
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

.tooth-editor {
    position: fixed;

    top: 50%;
    left: 50%;

    transform: translate(-50%, -50%);

    width: 320px;

    background: white;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 15px;

    box-shadow: 0 10px 25px rgba(0,0,0,.15);

    display: none;
    z-index: 99999;
}

</style>

{{-- ===================================================== --}}
{{-- SCRIPT --}}
{{-- ===================================================== --}}


<script>
// send config to js
const dentalConditions = @json(
    config('dental-chart.conditions')
);

</script>
<script>


document.addEventListener('DOMContentLoaded', function () {

        const editor = document.getElementById('tooth-editor');
    const editorTitle = document.getElementById('editor-title');
    const backdrop =document.getElementById('tooth-editor-backdrop');




    const dentalRecords = @json($records);



            if (backdrop && editor) {
                backdrop.addEventListener('click', function () {
                    editor.style.display = 'none';
                    backdrop.style.display = 'none';
                });
            }

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

        // old
       // surface.classList.add(record.condition);
        if (record.condition && dentalConditions[record.condition]) {

        surface.style.backgroundColor =  dentalConditions[record.condition];

        }

    });
}

   applyInitialState();
    // =====================================
    // CLICK HANDLER
    // =====================================
    document.querySelector('.card').addEventListener('click', function(e) {

        const surface = e.target.closest('.surface');
        if (!surface) return;

            const surfaces = document.querySelectorAll('.surface');
            surfaces.forEach(s =>
                s.classList.remove('active')
            );

        surface.classList.add('active');

        activeSurfaceElement = surface;
        activeTooth = surface.dataset.tooth;
        activeSide = surface.dataset.side;

            const rect = surface.getBoundingClientRect();


             backdrop.style.display = 'block';
            editor.style.display = 'block';

        editorTitle.innerText =`Tooth ${activeTooth} - ${activeSide}`;

        const existing = dentalRecords.find(r =>
            r.tooth_number == activeTooth &&
            r.surface == activeSide
        );


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

            const text = await res.text();
            console.log("SERVER RESPONSE:", text);

            if (!res.ok) {
                alert("Save failed");
                return;
            }

        if (res.ok) {
            /* // old ver
            activeSurfaceElement.classList.remove(
                'healthy','decay','filling','crown',
                'missing','extraction','sealant'
            );

            if (conditionSelect.value) {
                activeSurfaceElement.classList.add(conditionSelect.value);
            }

            */

            activeSurfaceElement.style.backgroundColor = '';

            if (
                conditionSelect.value &&
                dentalConditions[conditionSelect.value]
            ) {
                activeSurfaceElement.style.backgroundColor =
                    dentalConditions[conditionSelect.value];
            }

            // update local cache (IMPORTANT FIX)
            const existing = dentalRecords.find(r =>
                r.tooth_number == activeTooth &&
                r.surface == activeSide
            );


                editor.style.display = 'none';
                backdrop.style.display = 'none';

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

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.surface') && !e.target.closest('#tooth-editor')) {
                editor.style.display = 'none';
                backdrop.style.display = 'none';
            }
        });



    });






});




</script>