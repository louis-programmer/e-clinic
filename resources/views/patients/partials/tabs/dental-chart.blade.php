{{-- ===================================================== --}}
{{-- DENTAL CHART (ODONTOGRAM) --}}
{{-- ===================================================== --}}

<div class="card">

    <h3 style="margin-bottom:15px;">Dental Chart</h3>

    {{-- SELECTED TOOTH --}}
    <div style="
        background:#f8fafc;
        padding:12px;
        border-radius:10px;
        margin-bottom:15px;
    ">
        <strong>Selected Tooth:</strong>
        <div id="selected-tooth" style="color:#2563eb;font-weight:600;">
            None
        </div>
    </div>

    {{-- NOTES --}}
    <div style="margin-bottom:20px;">
        <label style="font-weight:600;display:block;margin-bottom:6px;">
            Tooth Notes
        </label>

        <textarea id="tooth-note"
                  class="form-input"
                  rows="4"
                  disabled
                  placeholder="Select a tooth first..."></textarea>
    </div>





    {{-- ===================================================== --}}
    {{-- TOP - LABIAL (PEDIATRIC) --}}
    {{-- ===================================================== --}}
    <div style="margin-bottom:15px;font-weight:600;">Labial (Pediatric Upper)</div>

    <div style="display:grid;grid-template-columns:repeat(10,1fr);gap:6px;margin-bottom:20px;">

        <button class="tooth">55</button>
        <button class="tooth">54</button>
        <button class="tooth">53</button>
        <button class="tooth">52</button>
        <button class="tooth">51</button>
        <button class="tooth">61</button>
        <button class="tooth">62</button>
        <button class="tooth">63</button>
        <button class="tooth">64</button>
        <button class="tooth">65</button>

    </div>





    {{-- ===================================================== --}}
    {{-- TOP - PERMANENT (LABIAL) --}}
    {{-- ===================================================== --}}
    <div style="margin-bottom:15px;font-weight:600;">Labial (Permanent Upper)</div>

    <div style="display:grid;grid-template-columns:repeat(16,1fr);gap:6px;margin-bottom:20px;">

        <button class="tooth">18</button>
        <button class="tooth">17</button>
        <button class="tooth">16</button>
        <button class="tooth">15</button>
        <button class="tooth">14</button>
        <button class="tooth">13</button>
        <button class="tooth">12</button>
        <button class="tooth">11</button>

        <button class="tooth">21</button>
        <button class="tooth">22</button>
        <button class="tooth">23</button>
        <button class="tooth">24</button>
        <button class="tooth">25</button>
        <button class="tooth">26</button>
        <button class="tooth">27</button>
        <button class="tooth">28</button>

    </div>





    {{-- ===================================================== --}}
    {{-- BOTTOM - PERMANENT (LINGUAL) --}}
    {{-- ===================================================== --}}
    <div style="margin-bottom:15px;font-weight:600;">Lingual (Permanent Lower)</div>

    <div style="display:grid;grid-template-columns:repeat(16,1fr);gap:6px;margin-bottom:20px;">

        <button class="tooth">48</button>
        <button class="tooth">47</button>
        <button class="tooth">46</button>
        <button class="tooth">45</button>
        <button class="tooth">44</button>
        <button class="tooth">43</button>
        <button class="tooth">42</button>
        <button class="tooth">41</button>

        <button class="tooth">31</button>
        <button class="tooth">32</button>
        <button class="tooth">33</button>
        <button class="tooth">34</button>
        <button class="tooth">35</button>
        <button class="tooth">36</button>
        <button class="tooth">37</button>
        <button class="tooth">38</button>

    </div>





    {{-- ===================================================== --}}
    {{-- BOTTOM - PEDIATRIC --}}
    {{-- ===================================================== --}}
    <div style="margin-bottom:15px;font-weight:600;">Labial (Pediatric Lower)</div>

    <div style="display:grid;grid-template-columns:repeat(10,1fr);gap:6px;">

        <button class="tooth">85</button>
        <button class="tooth">84</button>
        <button class="tooth">83</button>
        <button class="tooth">82</button>
        <button class="tooth">81</button>

        <button class="tooth">71</button>
        <button class="tooth">72</button>
        <button class="tooth">73</button>
        <button class="tooth">74</button>
        <button class="tooth">75</button>

    </div>

</div>





{{-- ===================================================== --}}
{{-- STYLES --}}
{{-- ===================================================== --}}
<style>

.tooth {
    border:none;
    background:#e2e8f0;
    padding:10px 6px;
    border-radius:8px;
    cursor:pointer;
    font-weight:700;
    transition:0.15s;
}

.tooth:hover {
    background:#cbd5e1;
}

.tooth.active {
    background:#2563eb;
    color:white;
}

</style>





{{-- ===================================================== --}}
{{-- SCRIPT --}}
{{-- ===================================================== --}}
<script>

const teeth = document.querySelectorAll('.tooth');

const display = document.getElementById('selected-tooth');

const noteBox = document.getElementById('tooth-note');

let activeTooth = null;

const notes = {};

teeth.forEach(btn => {

    btn.onclick = function () {

        teeth.forEach(t => t.classList.remove('active'));

        this.classList.add('active');

        activeTooth = this.innerText;

        display.innerText = "Tooth " + activeTooth;

        noteBox.disabled = false;

        noteBox.value = notes[activeTooth] || "";

        noteBox.placeholder = "Notes for tooth " + activeTooth;

    };

});

noteBox.addEventListener('input', function () {

    if (!activeTooth) return;

    notes[activeTooth] = this.value;

});

</script>