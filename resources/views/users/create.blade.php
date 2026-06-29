@extends('layouts.app')

@section('content')

<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
        flex-wrap:wrap;
        gap:10px;
    ">

        <div>

            <h2 style="margin:0;">
                Create User
            </h2>

            <div style="color:#64748b;">
                Add a new system user
            </div>

        </div>

        <a
            href="{{ route('users.index') }}"
            class="btn"
        >
            ← Back
        </a>

    </div>


    @if ($errors->any())

        <div style="
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#b91c1c;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        ">

            <strong>Please fix the following:</strong>

            <ul style="margin-top:10px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('users.store') }}"
    >

        @csrf


        <div style="margin-bottom:18px;">

            <label>Full Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:18px;">

            <label>Username</label>

            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:18px;">

            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:18px;">

            <label>Password</label>

            <input
                type="password"
                name="password"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:18px;">

            <label>Confirm Password</label>

            <input
                type="password"
                name="password_confirmation"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:25px;">

            <label>Role</label>

            <select
                name="role_id"
                class="form-input"
                style="width:100%;"
            >

                <option value="">
                    -- Select Role --
                </option>

                @foreach($roles as $role)

                    <option
                        value="{{ $role->id }}"
                        {{ old('role_id') == $role->id ? 'selected' : '' }}
                    >
                        {{ ucfirst($role->name) }}
                    </option>

                @endforeach

            </select>

        </div>


        <button
            class="btn"
            type="submit"
        >
            Create User
        </button>

    </form>

</div>

@endsection