<h1>Activate License</h1>

<p>Please enter your activation code.</p>

<form method="POST" action="{{ route('license.activate.store') }}">
    @csrf

    <input
        type="text"
        name="activation_code"
        class="form-input"
    >

    <button class="btn">
        Activate
    </button>
</form>