@if(session('success'))
    <div class="card" style="color:green;margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="card" style="color:red;margin-bottom:15px;">
        {{ session('error') }}
    </div>
@endif