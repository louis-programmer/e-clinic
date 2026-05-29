<!DOCTYPE html>
<html>
<head>
    <title>Login - Dental Clinic System</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body style="
    background:#f8fafc;
    font-family:'Inter', sans-serif;
">

<div class="auth-container">

    {{-- CARD --}}
    <div class="auth-card" style="
        position:relative;
        width: 380px;

        background: linear-gradient(180deg, #3b82f6, #60a5fa);

        padding: 34px;
        padding-bottom: 90px;

        border-radius: 16px;
        border: 1px solid rgba(59,130,246,0.25);

        box-shadow:
            0 12px 30px rgba(59,130,246,0.18);

        text-align:center;
        overflow:hidden;
    ">

        {{-- CLIENT LOGO --}}
        <div style="
            display:flex;
            justify-content:center;
            margin-bottom:16px;
        ">

            <div style="
                background:rgba(255,255,255,0.18);
                border:1px solid rgba(255,255,255,0.25);

                padding:14px;

                border-radius:18px;

                width:130px;
                height:130px;

                display:flex;
                align-items:center;
                justify-content:center;

                backdrop-filter: blur(6px);

                box-shadow:
                    0 6px 18px rgba(0,0,0,0.10);
            ">

                <img
                    src="{{ asset('images/toothfairy.jpg') }}"
                    alt="Tooth Fairy Dental Clinic"

                    style="
                        width:100px;
                        height:100px;

                        object-fit:cover;

                        border-radius:16px;

                        opacity:0.95;

                        box-shadow:
                            0 4px 12px rgba(0,0,0,0.12);
                    "
                >

            </div>

        </div>

        {{-- TITLE --}}
        <h2 style="
            color:#ffffff;
            margin-bottom:6px;

            font-size:30px;
            font-weight:700;

            letter-spacing:1px;
        ">
            Tooth Fairy Dental
        </h2>

        {{-- SUBTITLE --}}
        <p style="
            color:rgba(255,255,255,0.85);

            margin-bottom:22px;

            font-size:14px;

            letter-spacing:1px;
        ">
            Patient Management System
        </p>

        {{-- FORM --}}
        <form method="POST" action="/login">

            @csrf

            {{-- uname --}}
           <input
    type="text"
    name="username"
    placeholder="Username"
    required
    style="
        width:100%;
        padding:12px;
        margin-bottom:10px;
        border-radius:10px;
        border:1px solid rgba(255,255,255,0.35);
        background:rgba(255,255,255,0.22);
        color:#fff;
        font-size:15px;
        outline:none;
    "
>

            {{-- PASSWORD --}}
            <input
                type="password"
                name="password"
                placeholder="Password"
                required

                style="
                    width:100%;

                    padding:12px;
                    margin-bottom:14px;

                    border-radius:10px;

                    border:1px solid rgba(255,255,255,0.35);

                    background:rgba(255,255,255,0.22);

                    color:#fff;

                    font-size:15px;

                    outline:none;
                "
            >

            {{-- BUTTON --}}
            <button style="
                width:100%;

                background:#f8fafc;

                color:#1e3a8a;

                font-weight:700;

                padding:12px;

                border-radius:10px;

                border:none;

                cursor:pointer;

                font-size:15px;

                letter-spacing:1px;

                transition:0.2s ease;
            ">
                Login
            </button>

        </form>

        {{-- WATERMARK LOGO --}}
        <div style="
            position:absolute;

            bottom:6px;
            right:10px;

            background:rgba(255,255,255,0.12);

            border:1px solid rgba(255,255,255,0.20);

            padding:10px;

            border-radius:12px;

            display:flex;
            align-items:center;
            justify-content:center;
        ">

            <img
                src="{{ asset('images/InitialLogo.png') }}"

                style="
                    width:54px;
                    height:auto;

                    object-fit:contain;

                    opacity:0.45;

                    pointer-events:none;
                "
            >

        </div>

        {{-- BRANDING --}}
        <div style="
            margin-top:18px;
            text-transform:uppercase;
        ">

            <div style="
                font-size:18px;
                font-weight:700;

                color:#ffffff;

                letter-spacing:2px;
            ">
                Dental Clinic System
            </div>

            <div style="
                font-size:12px;

                color:rgba(255,255,255,0.85);

                margin-top:4px;

                letter-spacing:4px;
            ">
                CLINIC MANAGEMENT PLATFORM
            </div>

        </div>

    </div>

</div>

</body>
</html>