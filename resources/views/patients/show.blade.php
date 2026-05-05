@extends('layouts.app')

@section('content')
<!-- before -->
<!-- PATIENT HEADER -->
<div class="card">

    <h1>{{ $patient->first_name }} {{ $patient->last_name }}</h1>
    <p class="text-muted">Patient Profile</p>

    {{-- EDIT BUTTON --}}
    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
            <a href="/patients/{{ $patient->id }}/edit" class="btn">Edit</a>
        @endif
    @endauth


    <hr>

        @if(session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="color: red;">
                {{ session('error') }}
            </div>
        @endif

    {{-- UPLOAD FORM --}}
    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
            <form action="{{ route('patients.images.store', $patient->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <input type="file" name="image" accept="image/*">
                <button type="submit">Upload Image</button>
            </form>
        @endif
    @endauth

   <h3>Patient Images</h3>

<div style="display:flex; gap:10px; flex-wrap:wrap;">
    @forelse($patient->images ?? [] as $image)

        <div style="position:relative; width:150px; height:150px;">

            <!-- IMAGE -->
            <img
                src="{{ asset('storage/' . $image->file_path) }}"
                style="width:100%; height:100%; object-fit:cover; border-radius:8px; cursor:pointer;"
                onclick="openModal(this.src)"
            >

            <!-- DELETE BUTTON -->
            @auth
            @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
                <form method="POST"
                      action="{{ route('patients.images.destroy', $image->id) }}"
                      style="position:absolute; top:5px; right:5px;">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            onclick="return confirm('Delete this image?')"
                            style="
                                background:red;
                                color:white;
                                border:none;
                                padding:4px 6px;
                                border-radius:5px;
                                cursor:pointer;
                            ">
                        ✕
                    </button>
                </form>
            @endif
            @endauth

        </div>

    @empty
        <p>No images uploaded yet.</p>
    @endforelse
</div>

<!-- BASIC INFO -->
<div class="card" style="margin-top:15px;">
    <h3>Basic Information</h3>

    <p><strong>Full Name:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>

    <p>
        <strong>Birthdate:</strong>
        {{ $patient->birthdate?->format('M d, Y') ?? 'N/A' }}
        ({{ $patient->age ?? 'N/A' }} years old)
    </p>

    <p><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</p>
    <p><strong>Contact:</strong> {{ $patient->contact_number ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>
</div>

<!-- ADD ENCOUNTER -->
<div class="card" style="margin-top:15px;">
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

<!-- ENCOUNTER HISTORY (CLEAN TIMELINE) -->
<div class="card" style="margin-top:15px;">
    <h3>Encounter History</h3>

    @forelse($patient->encounters as $encounter)

        <div style="
            position: relative;
            margin-left: 20px;
            padding: 15px 15px 15px 25px;
            border-left: 2px solid #e2e8f0;
        ">

            <!-- DOT -->
            <div style="
                position: absolute;
                left: -7px;
                top: 18px;
                width: 12px;
                height: 12px;
                background: #3b82f6;
                border-radius: 50%;
                border: 2px solid #fff;
            "></div>

            <!-- CONTENT -->
            <div>

                <div style="font-size:12px; color:#64748b; margin-bottom:8px;">
                    {{ optional($encounter->encounter_date)->format('M d, Y h:i A') ?? 'No date' }}
                </div>

                <p><strong>Chief Complaint:</strong><br>
                    {{ $encounter->chief_complaint ?? '—' }}
                </p>

                <p><strong>Diagnosis:</strong><br>
                    {{ $encounter->diagnosis ?? '—' }}
                </p>

                <p><strong>Notes:</strong><br>
                    {{ $encounter->notes ?? '—' }}
                </p>

                <a href="/encounters/{{ $encounter->id }}/edit" class="btn">
                    Edit
                </a>

            </div>

        </div>

    @empty
        <p>No encounters yet.</p>
    @endforelse

</div>

@endsection


<script>
    function openModal(src) {
        document.getElementById('imageModal').style.display = 'flex';
        document.getElementById('modalImage').src = src;
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }
</script>


<!-- IMAGE MODAL -->
<div id="imageModal"
     style="display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.8);
            justify-content:center;
            align-items:center;
            z-index:9999;"
     onclick="closeModal()">

    <img id="modalImage"
         style="max-width:90%;
                max-height:90%;
                border-radius:10px;">
</div>