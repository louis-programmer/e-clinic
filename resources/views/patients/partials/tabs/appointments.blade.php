<div class="card" style="margin-top:20px;">
    <h3>Appointments</h3>

    @forelse($patient->appointments ?? [] as $appointment)

        <div style="
            position:relative;
            padding:15px;
            border-left:3px solid #3b82f6;
            margin-bottom:15px;
            background:#f8fafc;
            border-radius:8px;
        ">

            <!-- DATE -->
            <div style="font-size:12px; color:#64748b; margin-bottom:6px;">
                {{ $appointment->appointment_date?->format('M d, Y h:i A') }}
            </div>

            <!-- PURPOSE -->
            <p style="margin:0 0 6px 0;">
                <strong>Purpose:</strong>
                {{ $appointment->purpose ?? '—' }}
            </p>

            <!-- STATUS -->
            <p style="margin:0 0 6px 0;">
                <strong>Status:</strong>
                <span style="
                    padding:2px 8px;
                    border-radius:6px;
                    background:#e2e8f0;
                    font-size:12px;
                ">
                    {{ ucfirst($appointment->status ?? 'pending') }}
                </span>
            </p>

            <!-- NOTES -->
            <p style="margin:0;">
                <strong>Notes:</strong><br>
                {{ $appointment->notes ?? '—' }}
            </p>

        </div>

    @empty
        <p>No appointments yet.</p>
    @endforelse
</div>