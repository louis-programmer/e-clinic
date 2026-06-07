@extends('layouts.app')

@section('content')


<div class="card">

    <h1>Clinic Profile</h1>

    @if(session('success'))
        <div style="
            color:green;
            margin-bottom:15px;
        ">
            {{ session('success') }}
        </div>
    @endif

        <form
            method="POST"
            action="/clinic-profile"
            enctype="multipart/form-data"
        >
        @csrf

        <div style="margin-bottom:15px;">


<div style="margin-bottom:20px;">

    @if($profile->logo_path)

        <img
            src="{{ asset('storage/' . $profile->logo_path) }}"
            style="
                width:120px;
                height:120px;
                object-fit:contain;
                border:1px solid #e2e8f0;
                border-radius:10px;
            "
        >

    @else

        <div style="
            width:120px;
            height:120px;
            border:1px dashed #cbd5e1;
            display:flex;
            align-items:center;
            justify-content:center;
        ">
            No Logo
        </div>

    @endif

</div>

<div style="margin-bottom:20px;">

    <label>Clinic Logo</label>

    <input
        type="file"
        name="logo"
        accept=".jpg,.jpeg,.png,.webp"
    >

</div>


<div style="margin-bottom:20px;">

    <label>
        GCash QR
    </label>

    <input
        type="file"
        name="gcash_qr"
        accept="image/*"
    >

</div>

@if($profile->gcash_qr_path)

    <div style="margin-top:10px;">

        <img
            src="{{ asset('storage/' . $profile->gcash_qr_path) }}"
            style="
                width:200px;
                border:1px solid #ddd;
                border-radius:10px;
            "
        >

    </div>

@endif


<div style="margin-bottom:20px;">

    <label>
        Maya QR
    </label>

    <input
        type="file"
        name="maya_qr"
        accept="image/*"
    >

</div>

@if($profile->maya_qr_path)

    <div style="margin-top:10px;">

        <img
            src="{{ asset('storage/' . $profile->maya_qr_path) }}"
            style="
                width:200px;
                border:1px solid #ddd;
                border-radius:10px;
            "
        >

    </div>

@endif


<div style="margin-bottom:15px;">

    <label>Bank Name</label>

    <input
        type="text"
        name="bank_name"
        value="{{ old('bank_name', $profile->bank_name) }}"
        class="form-input"
    >

</div>

<div style="margin-bottom:15px;">

    <label>Account Name</label>

    <input
        type="text"
        name="bank_account_name"
        value="{{ old('bank_account_name', $profile->bank_account_name) }}"
        class="form-input"
    >

</div>

<div style="margin-bottom:15px;">

    <label>Account Number</label>

    <input
        type="text"
        name="bank_account_number"
        value="{{ old('bank_account_number', $profile->bank_account_number) }}"
        class="form-input"
    >

</div>






            <label>
                Clinic Name
            </label>

            <input
                type="text"
                name="clinic_name"
                value="{{ old('clinic_name', $profile->clinic_name) }}"
                class="form-input"
                style="width:100%;"
            >

        </div>


        <div style="margin-bottom:15px;">

    <label>Contact Number</label>

    <input
        type="text"
        name="contact_number"
        value="{{ old('contact_number', $profile->contact_number) }}"
        class="form-input"
        style="width:100%;"
    >

</div>

        <div style="margin-bottom:15px;">

            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email', $profile->email) }}"
                class="form-input"
                style="width:100%;"
            >

        </div>

        <div style="margin-bottom:15px;">

            <label>Address</label>

            <textarea
                name="address"
                class="form-input"
                style="width:100%; min-height:100px;"
            >{{ old('address', $profile->address) }}</textarea>

        </div>

        <div style="margin-bottom:15px;">


<div style="margin-bottom:25px;">

    <label style="display:block; font-weight:700; margin-bottom:12px;">
        Enabled Payment Methods
    </label>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
        gap:15px;
    ">

        {{-- CASH --}}
        <label style="
            border:1px solid #e2e8f0;
            padding:15px;
            border-radius:12px;
            cursor:pointer;
            display:flex;
            flex-direction:column;
            gap:6px;
        ">
            <input type="checkbox"
                   name="enabled_payment_methods[]"
                   value="cash"
                   {{ in_array('cash', $profile->enabled_payment_methods ?? []) ? 'checked' : '' }}>

            <strong>💵 Cash</strong>
            <span style="font-size:12px;color:#64748b;">
                Direct cash payment
            </span>
        </label>

        {{-- GCASH --}}
        <label style="
            border:1px solid #e2e8f0;
            padding:15px;
            border-radius:12px;
            cursor:pointer;
            display:flex;
            flex-direction:column;
            gap:6px;
        ">
            <input type="checkbox"
                   name="enabled_payment_methods[]"
                   value="gcash"
                   {{ in_array('gcash', $profile->enabled_payment_methods ?? []) ? 'checked' : '' }}>

            <strong>📱 GCash</strong>
            <span style="font-size:12px;color:#64748b;">
                QR-based mobile payment
            </span>
        </label>

        {{-- MAYA --}}
        <label style="
            border:1px solid #e2e8f0;
            padding:15px;
            border-radius:12px;
            cursor:pointer;
            display:flex;
            flex-direction:column;
            gap:6px;
        ">
            <input type="checkbox"
                   name="enabled_payment_methods[]"
                   value="maya"
                   {{ in_array('maya', $profile->enabled_payment_methods ?? []) ? 'checked' : '' }}>

            <strong>📱 Maya</strong>
            <span style="font-size:12px;color:#64748b;">
                QR-based mobile payment
            </span>
        </label>

        {{-- BANK --}}
        <label style="
            border:1px solid #e2e8f0;
            padding:15px;
            border-radius:12px;
            cursor:pointer;
            display:flex;
            flex-direction:column;
            gap:6px;
        ">
            <input type="checkbox"
                   name="enabled_payment_methods[]"
                   value="bank"
                   {{ in_array('bank', $profile->enabled_payment_methods ?? []) ? 'checked' : '' }}>

            <strong>🏦 Bank Transfer</strong>
            <span style="font-size:12px;color:#64748b;">
                Manual bank deposit
            </span>
        </label>

    </div>
</div>


<div style="margin-top:25px;">

    <h3 style="margin-bottom:15px;">
        Payment Preview
    </h3>

    {{-- GCASH --}}
    @if(in_array('gcash', $profile->enabled_payment_methods ?? []))

        <div style="
            border:1px solid #e2e8f0;
            border-radius:12px;
            padding:15px;
            margin-bottom:15px;
        ">

            <strong>📱 GCash</strong>

            <div style="margin-top:10px;">

                @if($profile->gcash_qr_path)

                    <img src="{{ asset('storage/' . $profile->gcash_qr_path) }}"
                         style="width:180px; border-radius:10px; border:1px solid #ddd;">

                @else
                    <div style="color:#64748b;">
                        No QR uploaded
                    </div>
                @endif

            </div>

        </div>

    @endif


    {{-- MAYA --}}
    @if(in_array('maya', $profile->enabled_payment_methods ?? []))

        <div style="
            border:1px solid #e2e8f0;
            border-radius:12px;
            padding:15px;
            margin-bottom:15px;
        ">

            <strong>📱 Maya</strong>

            <div style="margin-top:10px;">

                @if($profile->maya_qr_path)

                    <img src="{{ asset('storage/' . $profile->maya_qr_path) }}"
                         style="width:180px; border-radius:10px; border:1px solid #ddd;">

                @else
                    <div style="color:#64748b;">
                        No QR uploaded
                    </div>
                @endif

            </div>

        </div>

    @endif


    {{-- BANK --}}
    @if(in_array('bank', $profile->enabled_payment_methods ?? []))

        <div style="
            border:1px solid #e2e8f0;
            border-radius:12px;
            padding:15px;
        ">

            <strong>🏦 Bank Transfer</strong>

            <div style="margin-top:10px; font-size:14px; color:#334155;">

                <div>
                    <strong>Bank:</strong>
                    {{ $profile->bank_name ?? 'N/A' }}
                </div>

                <div>
                    <strong>Account Name:</strong>
                    {{ $profile->bank_account_name ?? 'N/A' }}
                </div>

                <div>
                    <strong>Account Number:</strong>
                    {{ $profile->bank_account_number ?? 'N/A' }}
                </div>

            </div>

        </div>

    @endif

</div>




</div>




        <button
            type="submit"
            class="btn"
        >
            Save
        </button>

    </form>

</div>

@endsection