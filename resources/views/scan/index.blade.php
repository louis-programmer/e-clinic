<h2>Scan Patient</h2>

@if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div style="color: red">{{ session('error') }}</div>
@endif

<form method="POST" action="/scan">
    @csrf

    <input type="text" name="code" placeholder="Scan or enter code" autofocus>

    <button type="submit">Scan</button>
</form>

