@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Patients</h1>

@auth
    @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))
        <a href="/patients/create">Add Patient</a>
    @endif
@endauth


<!--
@auth
    @if(auth()->user()->hasRole('admin'))
        <a href="/patients/create" class="btn">Add Patient</a>
    @endif
@endauth
-->
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