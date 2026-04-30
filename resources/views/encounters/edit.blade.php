@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Edit Encounter</h1>

    <form method="POST" action="/encounters/{{ $encounter->id }}">
        @csrf
        @method('PUT')

        <!-- Encounter Info -->
        <div class="form-group">
            <label class="form-label">Encounter Date</label>
            <input class="form-input"
                type="datetime-local"
                name="encounter_date"
                value="{{ old('encounter_date', optional($encounter->encounter_date)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Chief Complaint</label>
            <input class="form-input"
                name="chief_complaint"
                value="{{ old('chief_complaint', $encounter->chief_complaint) }}">
        </div>

        <!-- Clinical Details -->
        <div class="form-group">
            <label class="form-label">Diagnosis</label>
            <input class="form-input"
                name="diagnosis"
                value="{{ old('diagnosis', $encounter->diagnosis) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Notes</label>
            <textarea class="form-input"
                name="notes"
                rows="4">{{ old('notes', $encounter->notes) }}</textarea>
        </div>

        <button class="btn btn-primary">Update Encounter</button>
    </form>
</div>
@endsection