{{-- ===================================================== --}}
{{-- CREATE APPOINTMENT --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3 style="margin:0;">Create Appointment</h3>
    </div>

    <form method="POST" action="{{ route('appointments.store', $patient->id) }}">
        @csrf

        <div style="margin-bottom:14px;">
            <label style="display:block;margin-bottom:6px;font-weight:600;">
                Date & Time
            </label>

            <input type="datetime-local"
                   name="appointment_date"
                   class="form-input"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;margin-bottom:6px;font-weight:600;">
                Purpose
            </label>

            <input type="text"
                   name="purpose"
                   class="form-input"
                   placeholder="General consultation">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;margin-bottom:6px;font-weight:600;">
                Notes
            </label>

            <textarea name="notes"
                      class="form-input"
                      rows="3"
                      placeholder="Additional notes..."></textarea>
        </div>

        <button class="btn btn-primary">+ Create Appointment</button>
    </form>
</div>









{{-- ===================================================== --}}
{{-- UPCOMING APPOINTMENTS --}}
{{-- ===================================================== --}}
<div class="card" id="upcoming-appointments" style="margin-top:20px;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
        <h3 style="margin:0;">Upcoming Appointments</h3>

        <div style="font-size:13px;color:#64748b;">
            Total: <strong>{{ $upcomingAppointments->total() }}</strong>
        </div>
    </div>





    {{-- PAGINATION TOP --}}
    @if($upcomingAppointments->hasPages())
        <div style="display:flex;justify-content:center;gap:10px;margin-bottom:20px;">

            @if($upcomingAppointments->onFirstPage())
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">←</span>
            @else
                <a href="{{ $upcomingAppointments->previousPageUrl() }}#upcoming-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">
                    ←
                </a>
            @endif

            <span style="padding:6px 12px;background:#3b82f6;color:white;border-radius:6px;">
                {{ $upcomingAppointments->currentPage() }}
            </span>

            @if($upcomingAppointments->hasMorePages())
                <a href="{{ $upcomingAppointments->nextPageUrl() }}#upcoming-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">
                    →
                </a>
            @else
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">→</span>
            @endif

        </div>
    @endif





    {{-- LIST --}}
    @forelse($upcomingAppointments as $appointment)

        @php
            $statusColors = [
                'scheduled' => '#2563eb',
                'completed' => '#16a34a',
                'cancelled' => '#dc2626',
                'rescheduled' => '#d97706',
                'no_show' => '#6b7280',
            ];

            $status = $appointment->status ?? 'scheduled';
            $statusColor = $statusColors[$status] ?? '#64748b';

            $canManage = auth()->user()->hasAnyRole(...config('roles.patient_manage'));

            $isLocked = in_array($status, ['completed','cancelled','no_show']);
        @endphp





        <div style="background:#f8fafc;border-left:4px solid {{ $statusColor }};border-radius:10px;padding:18px;margin-bottom:16px;">

            <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:20px;margin-bottom:14px;">
                <div>
                    <div style="font-size:13px;color:#64748b;margin-bottom:6px;">
                        {{ $appointment->appointment_date?->format('M d, Y h:i A') }}
                    </div>

                    <div style="font-size:16px;font-weight:600;">
                        {{ $appointment->purpose ?: 'General Appointment' }}
                    </div>
                </div>

                <div>
                    <span style="padding:6px 10px;border-radius:999px;background:{{ $statusColor }};color:white;font-size:12px;text-transform:capitalize;">
                        {{ str_replace('_', ' ', $status) }}
                    </span>
                </div>
            </div>





            <div style="margin-bottom:16px;color:#334155;line-height:1.6;">
                <strong>Notes:</strong><br>
                {{ $appointment->notes ?: 'No notes provided.' }}
            </div>





            @if(!$isLocked)

                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">

                    <form method="POST" action="{{ route('appointments.complete', $appointment->id) }}">
                        @csrf
                        <button class="btn btn-sm" style="background:#16a34a;color:white;">Complete</button>
                    </form>

                    <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}">
                        @csrf
                        <button class="btn btn-sm" style="background:#dc2626;color:white;">Cancel</button>
                    </form>

                    <form method="POST" action="{{ route('appointments.no-show', $appointment->id) }}">
                        @csrf
                        <button class="btn btn-sm" style="background:#6b7280;color:white;">No Show</button>
                    </form>

                    @if($canManage)
                        <form method="POST" action="{{ route('appointments.destroy', $appointment->id) }}" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm" style="background:#111827;color:white;">Delete</button>
                        </form>
                    @endif

                </div>

            @endif

        </div>

    @empty
        <div style="padding:35px;text-align:center;color:#64748b;">
            No upcoming appointments.
        </div>
    @endforelse





    {{-- PAGINATION BOTTOM --}}
    @if($upcomingAppointments->hasPages())
        <div style="display:flex;justify-content:center;gap:10px;margin-top:20px;">

            @if($upcomingAppointments->onFirstPage())
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">←</span>
            @else
                <a href="{{ $upcomingAppointments->previousPageUrl() }}#upcoming-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">←</a>
            @endif

            <span style="padding:6px 12px;background:#3b82f6;color:white;border-radius:6px;">
                {{ $upcomingAppointments->currentPage() }}
            </span>

            @if($upcomingAppointments->hasMorePages())
                <a href="{{ $upcomingAppointments->nextPageUrl() }}#upcoming-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">→</a>
            @else
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">→</span>
            @endif

        </div>
    @endif

</div>









{{-- ===================================================== --}}
{{-- PREVIOUS APPOINTMENTS --}}
{{-- ===================================================== --}}
<div class="card" id="previous-appointments" style="margin-top:20px;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h3 style="margin:0;">Previous Appointments</h3>

        <div style="font-size:13px;color:#64748b;">
            Total: <strong>{{ $previousAppointments->total() }}</strong>
        </div>
    </div>





    {{-- PAGINATION --}}
    @if($previousAppointments->hasPages())
        <div style="display:flex;justify-content:center;gap:10px;margin-bottom:20px;">

            @if($previousAppointments->onFirstPage())
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">←</span>
            @else
                <a href="{{ $previousAppointments->previousPageUrl() }}#previous-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">←</a>
            @endif

            <span style="padding:6px 12px;background:#3b82f6;color:white;border-radius:6px;">
                {{ $previousAppointments->currentPage() }}
            </span>

            @if($previousAppointments->hasMorePages())
                <a href="{{ $previousAppointments->nextPageUrl() }}#previous-appointments"
                   style="padding:6px 12px;background:#f1f5f9;border-radius:6px;text-decoration:none;">→</a>
            @else
                <span style="padding:6px 12px;background:#e2e8f0;border-radius:6px;color:#94a3b8;">→</span>
            @endif

        </div>
    @endif





    {{-- LIST --}}
    @forelse($previousAppointments as $appointment)

        @php
            $statusColors = [
                'scheduled' => '#2563eb',
                'completed' => '#16a34a',
                'cancelled' => '#dc2626',
                'rescheduled' => '#d97706',
                'no_show' => '#6b7280',
            ];

            $status = $appointment->status ?? 'scheduled';
            $statusColor = $statusColors[$status] ?? '#64748b';
        @endphp





        <div style="background:#f8fafc;border-left:4px solid {{ $statusColor }};border-radius:10px;padding:18px;margin-bottom:16px;opacity:.9;">

            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                <div>
                    <div style="font-size:13px;color:#64748b;">
                        {{ $appointment->appointment_date?->format('M d, Y h:i A') }}
                    </div>

                    <div style="font-size:16px;font-weight:600;">
                        {{ $appointment->purpose }}
                    </div>
                </div>

                <span style="padding:6px 10px;border-radius:999px;background:{{ $statusColor }};color:white;">
                    {{ str_replace('_',' ',$status) }}
                </span>
            </div>

            <div style="color:#334155;">
                {{ $appointment->notes ?: 'No notes' }}
            </div>

        </div>

    @empty
        <div style="padding:35px;text-align:center;color:#64748b;">
            No previous appointments.
        </div>
    @endforelse

</div>