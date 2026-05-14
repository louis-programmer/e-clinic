@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- TOP BAR --}}
{{-- ===================================================== --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-size:13px; color:#64748b; margin-bottom:4px;">Today</div>
        <div style="font-size:28px; font-weight:700; color:#0f172a;">
            {{ now()->format('F d, Y') }}
        </div>
    </div>

    <button class="btn" style="display:flex; align-items:center; gap:8px;">
        📅 Open Calendar
    </button>
</div>





{{-- ===================================================== --}}
{{-- STATS --}}
{{-- ===================================================== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px; margin-bottom:20px;">

    <a href="/patients" style="text-decoration:none; color:inherit;">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-size:13px; color:#64748b; margin-bottom:8px;">Total Patients</div>
                    <div style="font-size:34px; font-weight:700;">0</div>
                </div>
                <div style="font-size:42px;">👥</div>
            </div>
        </div>
    </a>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="font-size:13px; color:#64748b; margin-bottom:8px;">New Patients</div>
                <div style="font-size:34px; font-weight:700;">0</div>
            </div>
            <div style="font-size:42px;">✨</div>
        </div>
    </div>

</div>





{{-- ===================================================== --}}
{{-- FUTURE MIDDLE SECTION (placeholder for expansion) --}}
{{-- ===================================================== --}}
{{-- You can add charts, billing summaries, etc here later --}}




{{-- ===================================================== --}}
{{-- BOTTOM SECTION: APPOINTMENTS --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">

        <div>
            <h2 style="margin:0 0 4px 0; font-size:22px;">Appointments Today</h2>
            <div style="color:#64748b; font-size:14px;">Daily appointment overview</div>
        </div>

        <div style="background:#eff6ff; color:#2563eb; padding:8px 14px; border-radius:999px; font-size:13px; font-weight:600;">
            {{ $scheduledCount }} Scheduled
        </div>

    </div>

    @if($todayAppointments->isEmpty())

        <div style="background:#f8fafc; border-radius:12px; padding:40px; text-align:center; color:#64748b;">
            <div style="font-size:48px; margin-bottom:12px;">📅</div>
            <div style="font-size:18px; font-weight:600; margin-bottom:6px; color:#334155;">
                No appointments today
            </div>
            <div>Upcoming appointments will appear here.</div>
        </div>

    @else

        <div style="display:flex; flex-direction:column; gap:14px;">

            @foreach($todayAppointments as $appointment)

                <div style="border:1px solid #e2e8f0; border-radius:14px; padding:18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">

                    <div>
                        <div style="font-size:14px; color:#64748b; margin-bottom:6px;">
                            {{ $appointment->appointment_date->format('h:i A') }}
                        </div>

                        <div style="font-size:18px; font-weight:700;">
                            {{ $appointment->patient->full_name }}
                        </div>

                        <div style="color:#475569;">
                            {{ $appointment->purpose ?? 'General Consultation' }}
                        </div>
                    </div>

                    <div style="background:{{ $appointment->status_color }}20; color:{{ $appointment->status_color }}; padding:8px 14px; border-radius:999px; font-size:13px; font-weight:700;">
                        {{ $appointment->status_label }}
                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection