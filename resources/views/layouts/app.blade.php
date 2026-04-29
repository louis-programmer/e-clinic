<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Clinic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>



<body>

<!-- SIDEBAR -->
<aside class="app-sidebar">
    <div class="app-sidebar-brand">
        <h2>E-Clinic</h2>
    </div>

    <nav class="app-sidebar-nav">
        <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            Dashboard
        </a>

       <a href="/patients" class="nav-item {{ request()->is('patients*') ? 'active' : '' }}">
         Patients
        </a>

        <a href="#" class="nav-item">
            Encounters
        </a>
    </nav>
</aside>

<!-- TOPBAR -->
<header class="app-topbar">
    <div class="app-topbar-title">
        <strong>Dashboard</strong>
    </div>

    <div class="app-topbar-actions">
        @auth
            <span class="user-name">{{ auth()->user()->name }}</span>

            <form method="POST" action="/logout" class="logout-form">
                @csrf
                <button class="btn btn-logout">Logout</button>
            </form>
        @endauth
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="app-content">
    @yield('content')
</main>

</body>
</html>