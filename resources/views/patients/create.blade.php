@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Add Patient</h1>

    <form method="POST" action="/patients">
        @csrf

        <input class="form-input" name="first_name" placeholder="First Name">
        <input class="form-input" name="last_name" placeholder="Last Name">

            <select class="form-input" name="gender">
                <option value="">Select Gender</option>

                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                    Male
                </option>

                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                    Female
                </option>

                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                    Other
                </option>
            </select>
       
        <input class="form-input" name="contact_number" placeholder="Contact Number">

        

            <input class="form-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control"
                placeholder="Email"
            >


        <input class="form-input" name="address" placeholder="Address">
        <input class="form-input" type="date" name="birthdate" placeholder="Birthdate">

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection