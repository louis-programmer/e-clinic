<!DOCTYPE html>
<html>
<head>
    <title>Login - E-Clinic</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h2 class="auth-title">E-Clinic</h2>
        <p class="auth-subtitle">Sign in to continue</p>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="auth-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(session('error'))
            <div class="auth-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="/login">
            @csrf

            <input 
                class="form-input"
                type="email" 
                name="email" 
                placeholder="Email" 
                value="{{ old('email') }}" 
                required
            >

            <input 
                class="form-input"
                type="password" 
                name="password" 
                placeholder="Password" 
                required
            >

            <button class="btn btn-primary" style="width:100%;">
                Login
            </button>
        </form>

    </div>
</div>

</body>
</html>