<div class="card" style="width:320px; min-width:320px; position:sticky; top:20px;">

    {{-- PATIENT IMAGE --}}
    <div style="text-align:center; margin-bottom:20px;">

        @if(($patient->images ?? collect())->count())
            <img src="{{ asset('storage/' . $patient->images->first()->file_path) }}"
                 style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #e2e8f0;">
        @else
            <div style="width:120px;height:120px;margin:auto;border-radius:50%;background:#e2e8f0;
                        display:flex;align-items:center;justify-content:center;font-size:40px;color:#64748b;">
                👤
            </div>
        @endif

    </div>

    {{-- NAME --}}
    <div style="text-align:center; margin-bottom:20px;">
        <h2>{{ $patient->full_name }}</h2>
        <div style="color:#64748b;">Patient Profile</div>
    </div>

    <hr>

    {{-- INFO --}}
    <p><strong>Patient Code:</strong><br>{{ $patient->patient_code ?? 'N/A' }}</p>
    <p><strong>Age:</strong><br>{{ $patient->age ?? 'N/A' }}</p>
    <p><strong>Gender:</strong><br>{{ ucfirst($patient->gender) }}</p>
    <p><strong>Birthdate:</strong><br>{{ $patient->birthdate?->format('M d, Y') ?? 'N/A' }}</p>
    <p><strong>Contact:</strong><br>{{ $patient->contact_number ?? 'N/A' }}</p>
    <p><strong>Address:</strong><br>{{ $patient->address ?? 'N/A' }}</p>

    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
            <a href="/patients/{{ $patient->id }}/edit" class="btn" style="display:block;text-align:center;margin-top:15px;">
                Edit Patient
            </a>
        @endif
    @endauth

</div>