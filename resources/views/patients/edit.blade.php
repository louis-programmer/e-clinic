@extends('layouts.app')

@section('content')

<div class="card">
    <h1>Edit Patient</h1>

    <form method="POST" action="/patients/{{ $patient->id }}">
        @csrf
        @method('PUT')

    <input class="form-input" name="first_name" 
    value="{{ old('first_name', $patient->first_name) }}" placeholder="First Name">

<input class="form-input" name="last_name" 
    value="{{ old('last_name', $patient->last_name) }}" placeholder="Last Name">

<input class="form-input" type="date" name="birthdate" 
    value="{{ $patient->birthdate ? $patient->birthdate->format('Y-m-d') : '' }}">

<select class="form-input" name="gender">
    <option value="">Select Gender</option>

    <option value="male" {{ $patient->gender === 'male' ? 'selected' : '' }}>
        Male
    </option>

    <option value="female" {{ $patient->gender === 'female' ? 'selected' : '' }}>
        Female
    </option>

    <option value="other" {{ $patient->gender === 'other' ? 'selected' : '' }}>
        Other
    </option>
</select>

<input class="form-input" name="contact_number" 
    value="{{ old('contact_number', $patient->contact_number) }}" placeholder="Contact Number">

    <input class="form-input" name="email" 
    value="{{ old('email', $patient->email) }}" placeholder="Email">

<input class="form-input" name="address" 
    value="{{ old('address', $patient->address) }}" placeholder="Address">
        <button class="btn btn-primary">Update Patient</button>
    </form>
</div>

@endsection