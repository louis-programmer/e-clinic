@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- TOP BAR --}}
{{-- ===================================================== --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
    gap:12px;
">

    {{-- DATE --}}
    <div>

        <div style="
            font-size:13px;
            color:#64748b;
            margin-bottom:4px;
        ">
            Today
        </div>

        <div style="
            font-size:28px;
            font-weight:700;
            color:#0f172a;
        ">
            {{ now()->format('F d, Y') }}
        </div>

    </div>





    {{-- CALENDAR BUTTON --}}
    <button class="btn"
            style="
                display:flex;
                align-items:center;
                gap:8px;
            ">
        📅 Open Calendar
    </button>

</div>





{{-- ===================================================== --}}
{{-- STATS CARDS --}}
{{-- ===================================================== --}}
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    margin-bottom:20px;
">

    {{-- TOTAL PATIENTS --}}
    <a href="/patients"
       style="
            text-decoration:none;
            color:inherit;
       ">

        <div class="card"
             style="
                cursor:pointer;
                transition:.2s;
             ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
            ">

                <div>

                    <div style="
                        font-size:13px;
                        color:#64748b;
                        margin-bottom:8px;
                    ">
                        Total Patients
                    </div>

                    <div style="
                        font-size:34px;
                        font-weight:700;
                        color:#0f172a;
                    ">
                        0
                    </div>

                </div>





                <div style="
                    font-size:42px;
                ">
                    👥
                </div>

            </div>

        </div>

    </a>





    {{-- NEW PATIENTS --}}
    <div class="card">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
        ">

            <div>

                <div style="
                    font-size:13px;
                    color:#64748b;
                    margin-bottom:8px;
                ">
                    New Patients
                </div>

                <div style="
                    font-size:34px;
                    font-weight:700;
                    color:#0f172a;
                ">
                    0
                </div>

            </div>





            <div style="
                font-size:42px;
            ">
                ✨
            </div>

        </div>

    </div>

</div>





{{-- ===================================================== --}}
{{-- APPOINTMENTS TODAY --}}
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

            <h2 style="
                margin:0 0 4px 0;
                font-size:22px;
            ">
                Appointments Today
            </h2>

            <div style="
                color:#64748b;
                font-size:14px;
            ">
                Daily appointment overview
            </div>

        </div>





        <div style="
            background:#eff6ff;
            color:#2563eb;
            padding:8px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:600;
        ">
            0 Scheduled
        </div>

    </div>





    {{-- EMPTY STATE --}}
    <div style="
        background:#f8fafc;
        border-radius:12px;
        padding:40px;
        text-align:center;
        color:#64748b;
    ">

        <div style="
            font-size:48px;
            margin-bottom:12px;
        ">
            📅
        </div>

        <div style="
            font-size:18px;
            font-weight:600;
            margin-bottom:6px;
            color:#334155;
        ">
            No appointments today
        </div>

        <div>
            Upcoming appointments will appear here.
        </div>

    </div>

</div>

@endsection