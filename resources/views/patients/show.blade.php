@extends('layouts.app')

@section('content')

<div style="display:flex; gap:20px; align-items:flex-start;">

    <!-- ===================================================== -->
    <!-- LEFT SIDEBAR -->
    <!-- ===================================================== -->
    <div class="card" style="width:320px; min-width:320px; position:sticky; top:20px;">

        <!-- PATIENT IMAGE -->
        <div style="text-align:center; margin-bottom:20px;">
            @if(($patient->images ?? collect())->count())
                <img src="{{ asset('storage/' . $patient->images->first()->file_path) }}"
                     style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #e2e8f0;">
            @else
                <div style="width:120px;height:120px;margin:auto;border-radius:50%;
                            background:#e2e8f0;display:flex;align-items:center;justify-content:center;
                            font-size:40px;color:#64748b;">
                    👤
                </div>
            @endif
        </div>

        <!-- NAME -->
        <div style="text-align:center; margin-bottom:20px;">
            <h2 style="margin-bottom:5px;">{{ $patient->full_name }}</h2>
            <div style="color:#64748b;">Patient Profile</div>
        </div>

        <hr>

        <!-- BASIC INFO -->
        <div style="margin-top:20px;">
            <p><strong>Patient Code:</strong><br>{{ $patient->patient_code ?? 'N/A' }}</p>
            <p><strong>Age:</strong><br>{{ $patient->age ?? 'N/A' }}</p>
            <p><strong>Gender:</strong><br>{{ ucfirst($patient->gender) }}</p>
            <p><strong>Birthdate:</strong><br>{{ $patient->birthdate?->format('M d, Y') ?? 'N/A' }}</p>
            <p><strong>Contact:</strong><br>{{ $patient->contact_number ?? 'N/A' }}</p>
            <p><strong>Address:</strong><br>{{ $patient->address ?? 'N/A' }}</p>
        </div>

        <!-- EDIT -->
        @auth
            @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
                <div style="margin-top:20px;">
                    <a href="/patients/{{ $patient->id }}/edit"
                       class="btn"
                       style="display:block;text-align:center;">
                        Edit Patient
                    </a>
                </div>
            @endif
        @endauth

    </div>

    <!-- ===================================================== -->
    <!-- MAIN CONTENT -->
    <!-- ===================================================== -->
    <div style="flex:1;">

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div class="card" style="color:green; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="card" style="color:red; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- ===================================================== -->
        <!-- TABS HEADER -->
        <!-- ===================================================== -->
        <div class="card">

            <div style="display:flex; gap:10px; border-bottom:1px solid #e2e8f0;
                        padding-bottom:10px; margin-bottom:20px;">

                <button class="tab-btn active-tab" onclick="openTab(event,'overview')">Overview</button>
                <button class="tab-btn" onclick="openTab(event,'notes')">Progress Notes</button>
                <button class="tab-btn" onclick="openTab(event,'photos')">Photos</button>
                <button class="tab-btn" onclick="openTab(event,'dental-chart')">Dental Chart</button>
                <button class="tab-btn" onclick="openTab(event,'appointments')">Appointments</button>

            </div>

            <!-- ===================================================== -->
            <!-- TAB CONTENTS -->
            <!-- ===================================================== -->

            {{-- OVERVIEW --}}
            <div id="overview" class="tab-content">
                @include('patients.partials.tabs.overview')
            </div>

            {{-- NOTES --}}
            <div id="notes" class="tab-content" style="display:none;">
                @include('patients.partials.tabs.progress-notes')
            </div>

            {{-- PHOTOS --}}
            <div id="photos" class="tab-content" style="display:none;">
                @include('patients.partials.tabs.photos')
            </div>

            {{-- DENTAL CHART --}}
            <div id="dental-chart" class="tab-content" style="display:none;">
                @include('patients.partials.tabs.dental-chart')
            </div>

          {{-- APPOINTMENTS --}}
            <div id="appointments"
                 class="tab-content"
                 style="display:none;">

                @include('patients.partials.tabs.appointments')

            </div>
          

        </div>

    </div>
</div>

<!-- ===================================================== -->
<!-- IMAGE MODAL -->
<!-- ===================================================== -->
<div id="imageModal"
     style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.8);justify-content:center;align-items:center;z-index:9999;"
     onclick="closeModal()">

    <img id="modalImage" style="max-width:90%;max-height:90%;border-radius:10px;">
</div>

<!-- ===================================================== -->
<!-- JS -->
<!-- ===================================================== -->
<script>

function openModal(src) {
    document.getElementById('imageModal').style.display = 'flex';
    document.getElementById('modalImage').src = src;
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Tabs

function openTab(event, tabId)
{
    document.querySelectorAll('.tab-content')
        .forEach(t => t.style.display = 'none');

    document.querySelectorAll('.tab-btn')
        .forEach(b => b.classList.remove('active-tab'));

    document.getElementById(tabId).style.display = 'block';

    event.currentTarget.classList.add('active-tab');

    // SAVE LAST TAB
    localStorage.setItem('activePatientTab', tabId);
}

window.addEventListener('load', () => {

    const savedTab = localStorage.getItem('activePatientTab');

    if (savedTab) {

        const tabButton = document.querySelector(
            `[onclick="openTab(event,'${savedTab}')"]`
        );

        if (tabButton) {
            tabButton.click();
        }

        return;
    }

    // fallback to overview
    const defaultTab = document.querySelector(
        `[onclick="openTab(event,'overview')"]`
    );

    if (defaultTab) {
        defaultTab.click();
    }

});



</script>

<!-- ===================================================== -->
<!-- STYLES -->
<!-- ===================================================== -->
<style>
.tab-btn {
    border:none;
    background:#f1f5f9;
    padding:10px 16px;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.active-tab {
    background:#3b82f6;
    color:white;
}
</style>

@endsection