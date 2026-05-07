<div class="card">
    <h3>Add Encounter</h3>

    <form method="POST" action="{{ route('encounters.store', $patient->id) }}">
        @csrf

        <label>Chief Complaint</label>
        <textarea class="form-input" name="chief_complaint"></textarea>

        <label>Doctor Notes</label>
        <textarea class="form-input" name="notes"></textarea>

        <label>Diagnosis</label>
        <textarea class="form-input" name="diagnosis"></textarea>

        <button class="btn btn-primary">Save Encounter</button>
    </form>
</div>

<div class="card" style="margin-top:20px;">
    <h3>Encounter History</h3>

    @forelse($patient->encounters as $encounter)
        <div style="margin-bottom:20px;padding:15px;border-left:2px solid #e2e8f0;position:relative;">

            <div style="position:absolute;left:-7px;top:18px;width:12px;height:12px;background:#3b82f6;border-radius:50%;border:2px solid #fff;"></div>

            <div style="font-size:12px;color:#64748b;">
                {{ optional($encounter->encounter_date)->format('M d, Y h:i A') }}
            </div>

            <p><strong>Chief Complaint:</strong><br>{{ $encounter->chief_complaint ?? '—' }}</p>
            <p><strong>Diagnosis:</strong><br>{{ $encounter->diagnosis ?? '—' }}</p>
            <p><strong>Notes:</strong><br>{{ $encounter->notes ?? '—' }}</p>

            <a href="/encounters/{{ $encounter->id }}/edit" class="btn">Edit</a>

        </div>
    @empty
        <p>No encounters yet.</p>
    @endforelse
</div>