@extends('layouts.app')

@section('content')

<div class="card">
    <h1>{{ $patient->first_name }} {{ $patient->last_name }}</h1>
    <p class="text-muted">Patient Profile</p>
    <a href="/patients/{{ $patient->id }}/edit" class="btn">
    Edit
</a>
</div>

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

<div class="card" style="margin-top:15px;">
    <h3>Encounters</h3>
    <div class="card" style="margin-top:15px;">
    <h3>Add Encounter</h3>

    <form method="POST" action="/patients/{{ $patient->id }}/encounters">
        @csrf

        <textarea class="form-input" name="chief_complaint" placeholder="Chief Complaint"></textarea>
        <textarea class="form-input" name="notes" placeholder="Doctor Notes"></textarea>
        <textarea class="form-input" name="diagnosis" placeholder="Diagnosis"></textarea>

        <button class="btn btn-primary">Save Encounter</button>
    </form>

    <div class="card" style="margin-top:15px;">
    <h3>Encounters</h3>

    @forelse($patient->encounters as $encounter)
        <div style="border-bottom:1px solid #eee; padding:10px 0;">
            <strong>{{ $encounter->encounter_date }}</strong><br>
            <small>Complaint: {{ $encounter->chief_complaint }}</small><br>
            <small>Diagnosis: {{ $encounter->diagnosis }}</small>
        </div>
    @empty
        <p>No encounters yet.</p>
    @endforelse
</div>

</div>
</div>

@endsection