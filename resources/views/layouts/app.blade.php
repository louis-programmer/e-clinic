<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Clinic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- REMINDER FIX CSS (isolated, no conflicts) -->
    <style>

/* ========================= */
/* REMINDER FAB BUTTON */
/* ========================= */
#reminder-fab {
    position: fixed;
    top: 90px; /* ⬅️ MOVE IT DOWN HERE */
    right: 20px;
    z-index: 9999;
}

#reminder-fab button {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    background: #2563eb;
    color: white;
    font-size: 24px;
    cursor: pointer;
}


#reminder-drawer {
    position: fixed;
    top: 0;
    right: 0;
    width: 350px;
    height: 100%;
    background: white;
    box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 9998;
    padding: 15px;
}

#reminder-drawer.open {
    transform: translateX(0);
}

#reminder-fab {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

#reminder-fab button {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    background: #2563eb;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.reminder-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

textarea {
    width: 100%;
    height: 70px;
    margin-bottom: 10px;
}

.tabs {
    display:flex;
    gap:10px;
    margin-bottom:10px;
}

.tab {
    display:none;
}

.tab.active {
    display:block;
}

.reminder-item {
    padding:10px;
    border:1px solid #ddd;
    margin-bottom:8px;
}

.reminder-item.done {
    opacity:0.6;
    text-decoration: line-through;
}
    </style>

    <style>
#reminder-fab {
    position: fixed !important;
    top: 120px !important;
    right: 20px !important;
    z-index: 99999 !important;
}
</style>
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


<!-- REMINDER BUTTON -->
<div id="reminder-fab">
    <button type="button" onclick="toggleReminders()">+</button>
</div>


<!-- REMINDER DRAWER -->
<div id="reminder-drawer">

    <div class="reminder-header">
        <h3>Reminders</h3>
        <button type="button" onclick="toggleReminders()">✕</button>
    </div>

    <form method="POST" action="/reminders">
        @csrf

        <textarea name="note" placeholder="Write a reminder..." required></textarea>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <hr>

    <div class="tabs">
        <button type="button" onclick="showTab('pending')">Pending</button>
        <button type="button" onclick="showTab('done')">Done</button>
    </div>

    <div id="tab-pending" class="tab active">

        @forelse($globalRemindersPending ?? [] as $reminder)
            <div class="reminder-item">
                <div>{{ $reminder->note }}</div>

                <form method="POST" action="/reminders/{{ $reminder->id }}/done">
                    @csrf
                    <button type="submit">Done</button>
                </form>
            </div>
        @empty
            <p style="color:#64748b;">No pending reminders</p>
        @endforelse

    </div>

    <div id="tab-done" class="tab">

        @forelse($globalRemindersDone ?? [] as $reminder)
            <div class="reminder-item done">
                {{ $reminder->note }}
            </div>
        @empty
            <p style="color:#64748b;">No completed reminders</p>
        @endforelse

    </div>

</div>


<!-- SCRIPT -->
<script>

function toggleReminders() {
    const drawer = document.getElementById('reminder-drawer');
    drawer.classList.toggle('open');
}

function showTab(tab) {
    document.getElementById('tab-pending').classList.remove('active');
    document.getElementById('tab-done').classList.remove('active');

    document.getElementById('tab-' + tab).classList.add('active');
}

</script>

</body>
</html>