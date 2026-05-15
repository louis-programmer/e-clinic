<!DOCTYPE html>
<html>
<head>
    <title>Loading - E-Clinic</title>

    {{-- AUTO REDIRECT AFTER 3 SECONDS --}}
    <meta http-equiv="refresh" content="3;url=/" />

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        :root{
            --primary:#1e293b;
            --background:#475569;
            --card:#334155;
            --text:#ffffff;
            --muted:#cbd5e1;
            --accent:#3b82f6;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            background:var(--background);

            font-family:'Inter', sans-serif;

            overflow:hidden;
        }

        /* CARD */
        .loader-card{

            width:420px;

            background:var(--card);

            border-radius:18px;

            padding:40px 36px;

            text-align:center;

            border:1px solid rgba(255,255,255,0.08);

            box-shadow:
                0 15px 35px rgba(0,0,0,0.18);
        }

        /* LOGO AREA */
        .logo-wrap{

            width:100%;

            height:120px;

            display:flex;
            justify-content:center;
            align-items:center;

            margin-bottom:24px;
        }

        .logo{

            width:260px;
            height:auto;

            object-fit:contain;

            opacity:0.95;

            filter:
                drop-shadow(0 0 12px rgba(59,130,246,0.18));
        }

        /* TITLE */
        .brand-title{

            font-size:28px;
            font-weight:700;

            color:#ffffff;

            letter-spacing:1px;

            margin-bottom:8px;
        }

        .brand-subtitle{

            font-size:13px;

            color:var(--muted);

            letter-spacing:3px;

            text-transform:uppercase;
        }

        /* ACCENT */
        .accent{

            width:70px;
            height:4px;

            background:var(--accent);

            border-radius:999px;

            margin:18px auto 20px auto;
        }

        /* LOADING TEXT */
        .loading-text{

            font-size:14px;

            color:#ffffff;

            font-weight:600;

            letter-spacing:2px;

            margin-bottom:18px;
        }

        .loading-text::after{

            content:'Initializing System';
            animation:changeWords 12s infinite;
        }

        @keyframes changeWords{

            0%,24%{
                content:'Initializing System';
            }

            25%,49%{
                content:'Loading Resources';
            }

            50%,74%{
                content:'Connecting to Database';
            }

            75%,100%{
                content:'Securing Connection';
            }
        }

        /* LOADING BAR */
        .progress-container{

            width:100%;
            height:10px;

            background:rgba(255,255,255,0.10);

            border-radius:999px;

            overflow:hidden;

            margin-bottom:40px;
        }

        .progress-bar{

            height:100%;

            width:0%;

            border-radius:999px;

            background:linear-gradient(
                90deg,
                #60a5fa,
                #3b82f6,
                #2563eb
            );

            animation:loadBar 3s linear forwards;
        }

        @keyframes loadBar{

            from{
                width:0%;
            }

            to{
                width:100%;
            }
        }

        /* VPN AREA */
        .vpn-zone{

            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;

            margin-top:10px;
        }

        /* GLOBE */
        .globe{

            font-size:34px;

            margin-bottom:18px;

            animation:globeBounce 1.8s infinite ease-in-out;

            filter:drop-shadow(
                0 0 10px rgba(59,130,246,0.4)
            );
        }

        @keyframes globeBounce{

            0%{
                transform:translateY(0px) rotate(0deg);
            }

            20%{
                transform:translateY(-8px) rotate(-6deg);
            }

            40%{
                transform:translateY(-18px) rotate(8deg);
            }

            60%{
                transform:translateY(-10px) rotate(-4deg);
            }

            80%{
                transform:translateY(-14px) rotate(5deg);
            }

            100%{
                transform:translateY(0px) rotate(0deg);
            }
        }

        /* COUNTRIES */
        .countries{

            font-size:13px;

            color:#cbd5e1;

            letter-spacing:2px;

            min-height:20px;
        }

        .countries::after{

            content:'Dubai';

            animation:countryFlash 5s infinite;
        }

        @keyframes countryFlash{

            0%{
                content:'Dubai';
            }

            20%{
                content:'China';
            }

            40%{
                content:'America';
            }

            60%{
                content:'Japan';
            }

            80%{
                content:'Russia';
            }

            100%{
                content:'Dubai';
            }
        }

        /* COPYRIGHT */
        .footer{

            margin-top:26px;

            font-size:11px;

            line-height:1.7;

            color:#94a3b8;
        }

    </style>

</head>

<body>

    <div class="loader-card">

        {{-- LOGO --}}
        <div class="logo-wrap">

            <img
                src="{{ asset('images/mainbrandlogo.png') }}"
                class="logo"
            >

        </div>

        {{-- TITLE --}}
        <div class="brand-title">
            E-Clinic
        </div>

        <div class="brand-subtitle">
            Dental Clinic Management System
        </div>

        <div class="accent"></div>

        {{-- LOADING STATUS --}}
        <div class="loading-text"></div>

        {{-- LOADING BAR --}}
        <div class="progress-container">

            <div class="progress-bar"></div>

        </div>

        {{-- VPN AREA --}}
        <div class="vpn-zone">

            {{-- GLOBE ABOVE --}}
            <div class="globe">
                🌍
            </div>

            {{-- COUNTRIES BELOW --}}
            <div class="countries"></div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="footer">

            © 2026 Lorem Ipsum Medical Technologies.<br>

            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.

        </div>

    </div>

</body>
</html>