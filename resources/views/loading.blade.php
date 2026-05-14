<!DOCTYPE html>
<html>
<head>
    <title>Loading - E-Clinic</title>

    {{-- AUTO REDIRECT AFTER 3 SECONDS --}}
    <meta http-equiv="refresh" content="3;url=/" />

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e293b;
            --background: #475569;
            --card: #334155;
            --text: #ffffff;
            --muted: #cbd5e1;
            --accent: #3b82f6;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

            background: var(--background);

            font-family: 'Inter', sans-serif;
        }

        /* CARD WRAPPER */
        .loader-card {
            background: var(--card);

            border-radius: 16px;

            padding: 42px 36px;

            width: 360px;

            text-align: center;

            border: 1px solid rgba(255,255,255,0.06);

            box-shadow:
                0 10px 25px rgba(0,0,0,0.08);
        }

        /* LOGO SAFE AREA */
        .logo-wrap {

            width: 120px;
            height: 120px;

            margin: 0 auto 18px auto;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #273549;

            border: 1px solid rgba(255,255,255,0.08);

            border-radius: 14px;
        }

        .logo {

            width: 90px;
            height: auto;

            object-fit: contain;

            opacity: 0.82;

            filter: saturate(0.9);
        }

        /* BRAND */
        .brand-title {

            font-size: 22px;
            font-weight: 700;

            color: #ffffff;

            letter-spacing: 1px;

            margin-bottom: 4px;
        }

        .brand-subtitle {

            font-size: 13px;

            color: #cbd5e1;

            letter-spacing: 3px;

            text-transform: uppercase;
        }

        /* LOADING */
        .loading {

            margin-top: 26px;

            font-size: 13px;

            color: #cbd5e1;

            letter-spacing: 2px;
        }

        .dots::after {
            content: '';
            animation: dots 1.5s infinite;
        }

        @keyframes dots {

            0% {
                content: '';
            }

            25% {
                content: '.';
            }

            50% {
                content: '..';
            }

            75% {
                content: '...';
            }

            100% {
                content: '';
            }
        }

        /* FOOT NOTE */
        .footer {

            margin-top: 18px;

            font-size: 11px;

            color: #94a3b8;

            letter-spacing: 1px;
        }

        /* ACCENT BAR */
        .accent {

            width: 60px;
            height: 3px;

            background: var(--accent);

            margin: 14px auto;

            border-radius: 10px;
        }

    </style>

</head>

<body>

    <div class="loader-card">

        {{-- SAFE LOGO AREA --}}
        <div class="logo-wrap">

            <img
                src="{{ asset('images/InitialLogo.png') }}"
                class="logo"
            >

        </div>

        {{-- BRAND --}}
        <div class="brand-title">
            E-Clinic
        </div>

        <div class="accent"></div>

        <div class="brand-subtitle">
            Dental Clinic Management System
        </div>

        {{-- LOADING --}}
        <div class="loading">

            INITIALIZING SYSTEM

            <span class="dots"></span>

        </div>

        {{-- FOOTER --}}
        <div class="footer">
            Secure Medical Platform
        </div>

    </div>

</body>
</html>