{{-- ===================================================== --}}
{{-- CREATE APPOINTMENT --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:15px;
    ">
        <h3 style="margin:0;">Create Appointment</h3>
    </div>

    <form method="POST"
          action="{{ route('appointments.store', $patient->id) }}">

        @csrf

        {{-- DATE --}}
        <label>Date & Time</label>

        <input type="datetime-local"
               name="appointment_date"
               class="form-input"
               required>

        {{-- PURPOSE --}}
        <label style="margin-top:10px;">Purpose</label>

        <input type="text"
               name="purpose"
               class="form-input">

        {{-- NOTES --}}
        <label style="margin-top:10px;">Notes</label>

        <textarea name="notes"
                  class="form-input"></textarea>

        {{-- BUTTON --}}
        <button class="btn btn-primary"
                style="margin-top:15px;">
            + Create Appointment
        </button>

    </form>

</div>





{{-- ===================================================== --}}
{{-- APPOINTMENTS LIST --}}
{{-- ===================================================== --}}
<div class="card" style="margin-top:20px;">

    <h3>Appointments</h3>

    {{-- TOP PAGINATION --}}
    @if($appointments->hasPages())
        <div style="margin-bottom:15px;">
            {{ $appointments->links() }}
        </div>
    @endif

    {{-- APPOINTMENTS --}}
    @forelse($appointments as $appointment)

        @php

            $statusColors = [
                'scheduled'   => '#3b82f6',
                'completed'   => '#16a34a',
                'cancelled'   => '#dc2626',
                'rescheduled' => '#f59e0b',
                'no_show'     => '#6b7280',
            ];

            $statusColor = $statusColors[$appointment->status] ?? '#64748b';

        @endphp

        <div style="
            position:relative;
            padding:15px;
            border-left:3px solid {{ $statusColor }};
            margin-bottom:15px;
            background:#f8fafc;
            border-radius:8px;
        ">

            {{-- DATE --}}
            <div style="
                font-size:12px;
                color:#64748b;
                margin-bottom:6px;
            ">
                {{ $appointment->appointment_date?->format('M d, Y h:i A') }}
            </div>

            {{-- PURPOSE --}}
            <p style="margin:0 0 6px 0;">
                <strong>Purpose:</strong>
                {{ $appointment->purpose ?? '—' }}
            </p>

            {{-- STATUS --}}
            <div style="margin-bottom:10px;">

                <strong>Status:</strong>

                <span style="
                    padding:4px 8px;
                    border-radius:6px;
                    font-size:12px;
                    color:white;
                    background:{{ $statusColor }};
                ">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status ?? 'scheduled')) }}
                </span>

            </div>

            {{-- NOTES --}}
            <p style="margin:0 0 12px 0;">
                <strong>Notes:</strong><br>
                {{ $appointment->notes ?? '—' }}
            </p>





            {{-- ===================================================== --}}
            {{-- ACTION BUTTONS --}}
            {{-- ===================================================== --}}
            <div style="
                display:flex;
                gap:8px;
                flex-wrap:wrap;
                margin-top:10px;
            ">

                {{-- COMPLETE --}}
                @if($appointment->status !== 'completed')

                    <form method="POST"
                          action="{{ route('appointments.complete', $appointment->id) }}">

                        @csrf

                        <button class="btn btn-sm">
                            Complete
                        </button>

                    </form>

                @endif



                {{-- CANCEL --}}
                @if($appointment->status !== 'cancelled')

                    <form method="POST"
                          action="{{ route('appointments.cancel', $appointment->id) }}">

                        @csrf

                        <button class="btn btn-sm"
                                style="background:red;color:white;">
                            Cancel
                        </button>

                    </form>

                @endif



                {{-- NO SHOW --}}
                @if($appointment->status !== 'no_show')

                    <form method="POST"
                          action="{{ route('appointments.no-show', $appointment->id) }}">

                        @csrf

                        <button class="btn btn-sm"
                                style="background:#6b7280;color:white;">
                            No Show
                        </button>

                    </form>

                @endif

            </div>





            {{-- ===================================================== --}}
            {{-- RESCHEDULE --}}
            {{-- ===================================================== --}}
            <form method="POST"
                  action="{{ route('appointments.reschedule', $appointment->id) }}"
                  style="margin-top:12px;">

                @csrf

                <input type="datetime-local"
                       name="appointment_date"
                       class="form-input">

                <button class="btn btn-sm"
                        style="margin-top:8px;">
                    Reschedule
                </button>

            </form>

        </div>

    @empty

        <p>No appointments yet.</p>

    @endforelse





    {{-- BOTTOM PAGINATION --}}
    @if($appointments->hasPages())

        <div style="margin-top:15px;">
            {{ $appointments->links() }}
        </div>

    @endif

</div>