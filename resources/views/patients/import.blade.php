@extends('layouts.app')

@section('content')

<div class="card">

    <h2>Import Legacy Patients</h2>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <form
        method="POST"
        action="{{ route('patients.import.store') }}"
        enctype="multipart/form-data"
    >

        @csrf

        <div style="margin-bottom:20px;">

            <label>Select CSV File</label>

            <input
                type="file"
                name="csv_file"
                class="form-input"
                accept=".csv"
            >
            @error('csv')

                <div style="color:red;">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <button class="btn">
            Upload CSV
        </button>

    </form>

</div>

@endsection