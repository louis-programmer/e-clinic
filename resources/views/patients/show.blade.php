@extends('layouts.app')

@section('content')

@php

$canProgressNotes = auth()->user()->canAccess('progress_notes');

$canOverviewHistory = auth()->user()->canAccess('overview_history');

$canPatientPhotos = auth()->user()->canAccess('patient_photos');

$canEncounter = auth()->user()->canAccess('encounter_view');

$canPatientXrays = auth()->user()->canAccess('patient_xrays');

$canPatientForms = auth()->user()->canAccess('patient_forms');

$canAppointments = auth()->user()->canAccess('appointments');

$canDentalDiagram = auth()->user()->canAccess('dental_diagram');

@endphp


<!-- ===================================================== -->
<!-- PATIENT HEADER -->
<!-- ===================================================== -->
<div class="cardHeader" style="
    margin-bottom:20px;
    display:flex;
    gap:25px;
    align-items:center;
    flex-wrap:wrap;
">

<!-- IMAGE + ACTIONS -->
<div style="
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:12px;
">

    {{-- EDIT BUTTON --}}
    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))

            <a href="/patients/{{ $patient->id }}/edit"
               class="btn"
               style="
                    width:120px;
                    text-align:center;
               ">

                Edit Patient

            </a>

        @endif
    @endauth





    {{-- PATIENT IMAGE --}}
    @if(($patient->images ?? collect())->count())

<!--
        <img src="{{ asset('storage/' . $patient->images->first()->file_path) }}"
             style="
                width:120px;
                height:120px;
                border-radius:50%;
                object-fit:cover;
                border:4px solid #e2e8f0;
             ">

    -->

    <!-- temporary default -->

      <div style="
            width:120px;
            height:120px;
            border-radius:50%;
            background:#e2e8f0;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:42px;
            color:#64748b;
        ">
            👤
        </div>

    @else

        <div style="
            width:120px;
            height:120px;
            border-radius:50%;
            background:#e2e8f0;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:42px;
            color:#64748b;
        ">
            👤
        </div>

    @endif

</div>




    <!-- PATIENT INFO -->
    <div style="flex:1; min-width:280px;">

        <h1 style="
            margin:0 0 6px 0;
            font-size:28px;
        ">
            {{ $patient->full_name }}
        </h1>

        <div style="
            color:#64748b;
            margin-bottom:18px;
        ">
            Patient Profile
        </div>





        <!-- INFO GRID -->
        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:14px;
        ">

            <div>
                <div style="font-size:12px;color:#64748b;">
                    Age
                </div>

                <div style="font-weight:600;">
                    {{ $patient->age ?? 'N/A' }}
                </div>
            </div>





            <div>
                <div style="font-size:12px;color:#64748b;">
                    Gender
                </div>

                <div style="font-weight:600;">
                    {{ ucfirst($patient->gender) }}
                </div>
            </div>





            <div>
                <div style="font-size:12px;color:#64748b;">
                    Birthdate
                </div>

                <div style="font-weight:600;">
                    {{ $patient->birthdate?->format('M d, Y') ?? 'N/A' }}
                </div>
            </div>





            <div>
                <div style="font-size:12px;color:#64748b;">
                    Contact
                </div>

                <div style="font-weight:600;">
                    {{ $patient->contact_number ?? 'N/A' }}
                </div>
            </div>


            <div>
                <div style="font-size:12px;color:#64748b;">
                    Email
                </div>

                <div style="font-weight:600;">
                    {{ $patient->email ?? 'N/A' }}
                </div>
            </div>




            <div style="grid-column:1 / -1;">

                <div style="font-size:12px;color:#64748b;">
                    Address
                </div>

                <div style="font-weight:600;">
                    {{ $patient->address ?? 'N/A' }}
                </div>

            </div>

        </div>

    </div>





</div>





<!-- ===================================================== -->
<!-- FLASH MESSAGES -->
<!-- ===================================================== -->
@if(session('success'))

    <div class="card"
         style="color:green;margin-bottom:15px;">

        {{ session('success') }}

    </div>

@endif





@if(session('error'))

    <div class="card"
         style="color:red;margin-bottom:15px;">

        {{ session('error') }}

    </div>

@endif





<!-- ===================================================== -->
<!-- MAIN CONTENT -->
<!-- ===================================================== -->
<div class="card">

    <!-- ===================================================== -->
    <!-- TABS -->
    <!-- ===================================================== -->
    <div style="
        display:flex;
        gap:10px;
        border-bottom:1px solid #e2e8f0;
        padding-bottom:10px;
        margin-bottom:20px;
        overflow-x:auto;
    ">

        @if($canOverviewHistory)

            <button class="tab-btn active-tab" data-tab="overview">
                History Overview
            </button>
        @endif

         @if($canProgressNotes)
             <button class="tab-btn" data-tab="notes">
                Procedures
            </button>
         @endif   

<!-- hidden for production | for dev -->
<!--
         <button class="tab-btn" data-tab="notes2">
            Patient Notes
        </button>

-->
        
         @if($canEncounter)
            <button class="tab-btn" data-tab="encounters">
                Consultation
            </button>
         @endif   


       @if($canPatientPhotos)
            <button class="tab-btn" data-tab="photos">
                Dental Photos
            </button>
        @endif

          @if($canPatientXrays)
            <button class="tab-btn" data-tab="xrays">
                X-Rays
            </button>
         @endif

         @if($canDentalDiagram)
            <button class="tab-btn" data-tab="dental-chart">
                Dental Diagram
            </button>
           @endif
           

        @if($canAppointments)
            <button class="tab-btn" data-tab="appointments">
                Appointments
            </button>
          @endif
          

          @if($canPatientForms)    
            <button class="tab-btn" data-tab="forms">
                Forms
            </button>
          @endif
    </div>




    <!-- ===================================================== -->
    <!-- TAB CONTENTS -->
    <!-- ===================================================== -->

    {{-- HISTORY --}}
    <div id="overview" class="tab-content">
        @include('patients.partials.tabs.overview')
    </div>


 {{-- PATIENT TIMELINE --}}
    <div id="notes"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.progress-notes')

    </div>


 {{-- PATIENT TIMELINE --}}
    <div id="notes2"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.progress2')

    </div>



    {{-- PATIENT TIMELINE --}}
    <div id="encounters"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.encounters')

    </div>





    {{-- DENTAL PHOTOS --}}
    <div id="photos"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.photos')

    </div>


   {{--  Xray  --}}
    <div id="xrays"        
     class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.xrays')
    </div>


    {{-- DENTAL DIAGRAM --}}
    <div id="dental-chart"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.dental-chart')

    </div>





    {{-- APPOINTMENTS --}}
    <div id="appointments"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.appointments')

    </div>


        {{-- FORMS --}}
    <div id="forms"
         class="tab-content"
         style="display:none;">

        @include('patients.partials.tabs.forms')

    </div>

</div>





<!-- ===================================================== -->
<!-- IMAGE MODAL -->
<!-- ===================================================== -->
<div id="imageModal"
     style="
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.8);
        justify-content:center;
        align-items:center;
        z-index:9999;
     "
     onclick="closeModal()">

    <img id="modalImage"
         style="
            max-width:90%;
            max-height:90%;
            border-radius:10px;
         ">

</div>





<!-- ===================================================== -->
<!-- JS -->
<!-- ===================================================== -->
<script>

function openModal(src)
{
    document.getElementById('imageModal').style.display = 'flex';

    document.getElementById('modalImage').src = src;
}

function closeModal()
{
    document.getElementById('imageModal').style.display = 'none';
}




function openTab(tabId)
    {
        document.querySelectorAll('.tab-content')
            .forEach(t => t.style.display = 'none');

        document.querySelectorAll('.tab-btn')
            .forEach(b => b.classList.remove('active-tab'));

        document.getElementById(tabId).style.display = 'block';

        document.querySelector(`[data-tab="${tabId}"]`)
            ?.classList.add('active-tab');
    }

    /* attach events safely */
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.tab;
            openTab(tab);
            localStorage.setItem('activePatientTab', tab);
        });
    });

    window.addEventListener('load', () => {

        const savedTab = localStorage.getItem('activePatientTab') || 'overview';

        const btn = document.querySelector(`[data-tab="${savedTab}"]`);

        if (btn) btn.click();
    });




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
    white-space:nowrap;
}

.active-tab {
    background:#3b82f6;
    color:white;
}

</style>

@endsection