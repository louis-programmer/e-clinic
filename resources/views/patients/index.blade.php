@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Patients</h1>

    <a href="/patients/create" class="btn">Add Patient</a>

    <br><br>

    @foreach ($patients as $patient)
        <div class="card" style="margin-bottom:10px;">
            
            <a href="/patients/{{ $patient->id }}">
                <strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong>
            </a>

            <br>
            <small>{{ $patient->contact_number }}</small>
        </div>
    @endforeach
</div>
@endsection