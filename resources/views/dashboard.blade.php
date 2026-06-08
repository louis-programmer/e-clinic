{{--dev notes

### Documented

### uses:
    -DashboardController.php
    -Invoice.php
    -InvoiceController.php
    -Payment.php
    -PaymemntController.php
    -add.blade.php
    


--}}


@extends('layouts.app')

@section('content')
{{-- ===================================================== --}}
{{-- WATERMARK LOGO (CIRCULAR + SAFE BOX) --}}
{{-- ===================================================== --}}

<div style="
    position:fixed;
    top:50%;
    left:55%;
    transform:translate(-50%, -50%);

    z-index:0;
    pointer-events:none;

    opacity:0.03;
">

    <div style="
        width:420px;
        height:420px;

        border-radius:50%;

        display:flex;
        justify-content:center;
        align-items:center;

        overflow:hidden;
    ">

        <img
            src="{{ asset('images/toothfairy2.jpg') }}"
            style="
                width:100%;
                height:100%;
                object-fit:cover;
            "
        >

    </div>

</div>
<div style="margin-bottom:24px;">

    <h2 style="
        margin:0;
        font-size:28px;
        font-weight:700;
        color:#0f172a;
    ">
        Welcome Admin
    </h2>

    <div style="
        margin-top:8px;
        display:flex;
        flex-direction:column;
        gap:2px;
    ">

        <div style="
            font-size:13px;
            color:#64748b;
            font-weight:500;
        ">
            Today
        </div>

       <div id="live-clock" style="
            font-size:16px;
            font-weight:600;
            color:#0f172a;
        "></div>

    </div>

</div>

<script>
function updateClock() {

    const now = new Date();

    const datePart = now.toLocaleDateString('en-PH', {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

    const timePart = now.toLocaleTimeString('en-PH', {
        timeZone: 'Asia/Manila',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    document.getElementById('live-clock').innerHTML = `
        <div style="font-size:12px; font-weight:600; color:#0f172a;">
            ${datePart}
        </div>
        <div style="font-size:16px; color:#008000; margin-top:2px;">
            ${timePart}
        </div>
    `;
}

updateClock();
setInterval(updateClock, 1000);
</script>

{{-- ===================================================== --}}
{{-- CALCULATOR MODAL --}}
{{-- ===================================================== --}}

<div
    id="calculator-modal"
    style="
        display:none;

        position:fixed;
        inset:0;

        background:rgba(0,0,0,0.35);

        justify-content:center;
        align-items:center;

        z-index:10000;
    "
>

    <div style="
        width:300px;

        background:#f8fafc;

        border-radius:16px;

        padding:18px;

        box-shadow:
            0 12px 35px rgba(0,0,0,0.25);

        position:relative;
    ">

        {{-- CLOSE --}}
        <button
            type="button"
            id="close-calculator-btn"
            style="
                position:absolute;
                top:10px;
                right:10px;

                border:none;
                background:none;

                font-size:20px;
                cursor:pointer;
            "
        >
            ✕
        </button>

        {{-- DISPLAY --}}
        <input
            type="text"
            id="calc-display"
            readonly

            style="
                width:100%;
                height:55px;

                margin-bottom:14px;

                border:1px solid #cbd5e1;
                border-radius:10px;

                background:white;

                text-align:right;

                padding:10px;

                font-size:24px;
            "
        >

        {{-- BUTTONS --}}
        <div style="
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:8px;
        ">

            <button onclick="clearCalc()">C</button>
            <button onclick="appendCalc('/')">÷</button>
            <button onclick="appendCalc('*')">×</button>
            <button onclick="deleteLast()">⌫</button>

            <button onclick="appendCalc('7')">7</button>
            <button onclick="appendCalc('8')">8</button>
            <button onclick="appendCalc('9')">9</button>
            <button onclick="appendCalc('-')">−</button>

            <button onclick="appendCalc('4')">4</button>
            <button onclick="appendCalc('5')">5</button>
            <button onclick="appendCalc('6')">6</button>
            <button onclick="appendCalc('+')">+</button>

            <button onclick="appendCalc('1')">1</button>
            <button onclick="appendCalc('2')">2</button>
            <button onclick="appendCalc('3')">3</button>

            <button
                onclick="calculate()"
                style="
                    background:#3b82f6;
                    color:white;
                    font-weight:700;
                "
            >
                =
            </button>

            <button
                style="grid-column:span 2;"
                onclick="appendCalc('0')"
            >
                0
            </button>

            <button onclick="appendCalc('.')">.</button>

        </div>

    </div>

</div>

<style>

#calculator-modal button{

    height:50px;

    border:none;

    border-radius:10px;

    background:white;

    font-size:18px;

    font-weight:600;

    cursor:pointer;
}

#calculator-modal button:hover{

    background:#e2e8f0;
}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const calcModal =
        document.getElementById('calculator-modal');

    const calcDisplay =
        document.getElementById('calc-display');

    const openBtn =
        document.getElementById('open-calculator-btn');

    const closeBtn =
        document.getElementById('close-calculator-btn');

    // SAFETY CHECK
    if (!openBtn || !closeBtn) return;

    openBtn.addEventListener('click', () => {

        calcModal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => {

        calcModal.style.display = 'none';
    });

    window.addEventListener('click', function(e){

        if (e.target === calcModal) {

            calcModal.style.display = 'none';
        }
    });

    // =====================================================
    // CALCULATOR FUNCTIONS
    // =====================================================

    window.appendCalc = function(value)
    {
        calcDisplay.value += value;
    }

    window.clearCalc = function()
    {
        calcDisplay.value = '';
    }

    window.deleteLast = function()
    {
        calcDisplay.value =
            calcDisplay.value.slice(0, -1);
    }

    window.calculate = function()
    {
        try {

            calcDisplay.value =
                eval(calcDisplay.value);

        } catch {

            calcDisplay.value = 'Error';
        }
    }

});

</script>


{{-- ===================================================== --}}
{{-- TOP BAR --}}
{{-- ===================================================== --}}







{{-- PLACE THIS BUTTON ANYWHERE --}}
<div style="
    display:flex;
    align-items:center;
    gap:10px;
">

    {{-- CALCULATOR --}}
    <button
        type="button"
        id="open-calculator-btn"
        style="
            padding:10px 14px;

            border:none;
            border-radius:10px;

            background:#3b82f6;
            color:white;

            font-size:16px;
            font-weight:600;

            cursor:pointer;
        "
    >
        🧮 Calculator
    </button>

    {{-- CALENDAR --}}
    <button
        class="btn"
        onclick="openCalendar()"
        style="
            display:flex;
            align-items:center;
            gap:8px;
        "
    >
        📅 Open Calendar
    </button>

</div>


<!-- suspected remnant closing div
</div>
-->

@if($birthdayPatients->count())
    <div class="card" style="
        margin-bottom:20px;
        background:#fff7ed;
        border:1px solid #fed7aa;
        color:#9a3412;
    ">

        <div style="font-weight:700; margin-bottom:8px;">
            🎉 Birthday Today
        </div>

        <div style="display:flex; flex-wrap:wrap; gap:10px;">
            @foreach($birthdayPatients as $patient)
                <div style="
                    background:#ffedd5;
                    padding:6px 10px;
                    border-radius:999px;
                    font-weight:600;
                ">
                    {{ $patient->full_name }}
                </div>
            @endforeach
        </div>

    </div>
@endif




{{-- ===================================================== --}}
{{-- STATS --}}
{{-- ===================================================== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px; margin-bottom:20px;">

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px; margin-bottom:20px;">

    {{-- TOTAL PATIENTS --}}
    <a href="/patients" style="text-decoration:none; color:inherit;">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
                        Total Patients
                    </div>

                    <div style="font-size:34px; font-weight:700;">
                        {{ number_format($totalPatients) }}
                    </div>
                </div>

                <div style="font-size:42px;">
                    👥
                </div>
            </div>
        </div>
    </a>

    {{-- NEW THIS MONTH --}}
    <div class="card">

        <div style="display:flex; justify-content:space-between; align-items:center;">

            <div>
                <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
                    New Patients This Month
                </div>

                <div style="font-size:34px; font-weight:700;">
                    {{ number_format($newPatientsThisMonth) }}
                </div>
            </div>

            <div style="font-size:42px;">
                ✨
            </div>

        </div>

    </div>

    {{-- LAST 6 MONTHS --}}
    <div class="card">

        <div style="display:flex; justify-content:space-between; align-items:center;">

            <div>
                <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
                    New Patients (6 Months)
                </div>

                <div style="font-size:34px; font-weight:700;">
                    {{ number_format($newPatientsLastSixMonths) }}
                </div>
            </div>

            <div style="font-size:42px;">
                📈
            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- FINANCIAL OVERVIEW --}}
{{-- ===================================================== --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:20px; margin-bottom:20px;">

    {{-- TODAY REVENUE --}}
    <div class="card">
        <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
            Today's Revenue
        </div>

        <div style="font-size:34px; font-weight:700;">
            ₱{{ number_format($todayRevenue, 2) }}
        </div>
    </div>

    {{-- OUTSTANDING BALANCE --}}
    <div class="card">
        <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
            Total Outstanding Balance
        </div>

        <div style="font-size:34px; font-weight:700; color:#dc2626;">
            ₱{{ number_format($totalOutstandingBalance, 2) }}
        </div>
    </div>

    {{-- UNPAID INVOICES --}}
    <div class="card">
        <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
            Unpaid Invoices
        </div>

        <div style="font-size:34px; font-weight:700;">
            {{ number_format($unpaidInvoices) }}
        </div>
    </div>

    {{-- PATIENTS SEEN TODAY --}}
    <div class="card">
        <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
            Patients Seen Today
        </div>

        <div style="font-size:34px; font-weight:700;">
            {{ number_format($patientsSeenToday) }}
        </div>
    </div>

</div>


<div class="card" style="margin-top:20px;">

    <h3>💰 Revenue (Last 6 Months)</h3>

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:10px;">

        @foreach($monthlyRevenueLast6Months as $month)
            <div style="
                padding:12px;
                border:1px solid #e2e8f0;
                border-radius:10px;
                text-align:center;
            ">
                <div style="font-size:13px; color:#64748b;">
                    {{ $month->month }}
                </div>

                <div style="font-size:18px; font-weight:700;">
                    ₱{{ number_format($month->total, 2) }}
                </div>
            </div>
        @endforeach

    </div>

</div>


<div class="card" style="margin-top:20px;">

    <h3>🏆 Top Treatments (By Revenue)</h3>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr>
                <th style="text-align:left;">Treatment</th>
                <th>Times Used</th>
                <th style="text-align:right;">Revenue</th>
            </tr>
        </thead>

        <tbody>

            @foreach($topTreatments as $treatment)
                <tr style="border-top:1px solid #e2e8f0;">
                    
                    <td style="padding:10px;">
                        {{ $treatment->procedure->name ?? $treatment->description ?? 'Unknown' }}
                    </td>

                    <td style="text-align:center;">
                        {{ $treatment->count }}
                    </td>

                    <td style="text-align:right; font-weight:700;">
                        ₱{{ number_format($treatment->revenue, 2) }}
                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

</div>

{{-- ===================================================== --}}
{{-- FUTURE MIDDLE SECTION (placeholder for expansion) --}}
{{-- ===================================================== --}}
{{-- You can add charts, billing summaries, etc here later --}}




{{-- ===================================================== --}}
{{-- BOTTOM SECTION: APPOINTMENTS --}}
{{-- ===================================================== --}}
<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">

        <div>
            <h2 style="margin:0 0 4px 0; font-size:22px;">Appointments Today</h2>
            <div style="color:#64748b; font-size:14px;">Daily appointment overview</div>
        </div>

        <div style="background:#eff6ff; color:#2563eb; padding:8px 14px; border-radius:999px; font-size:13px; font-weight:600;">
            {{ $scheduledCount }} Scheduled
        </div>

    </div>

    @if($todayAppointments->isEmpty())

        <div style="background:#f8fafc; border-radius:12px; padding:40px; text-align:center; color:#64748b;">
            <div style="font-size:48px; margin-bottom:12px;">📅</div>
            <div style="font-size:18px; font-weight:600; margin-bottom:6px; color:#334155;">
                No appointments today
            </div>
            <div>Upcoming appointments will appear here.</div>
        </div>

    @else

        <div style="display:flex; flex-direction:column; gap:14px;">

            @foreach($todayAppointments as $appointment)

                <div style="border:1px solid #e2e8f0; border-radius:14px; padding:18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">

                    <div>
                        <div style="font-size:14px; color:#64748b; margin-bottom:6px;">
                            {{ $appointment->appointment_date->format('h:i A') }}
                        </div>

                        <div style="font-size:18px; font-weight:700;">
                            {{ $appointment->patient->full_name }}
                        </div>

                        <div style="color:#475569;">
                            {{ $appointment->purpose ?? 'General Consultation' }}
                        </div>
                    </div>

                    <div style="background:{{ $appointment->status_color }}20; color:{{ $appointment->status_color }}; padding:8px 14px; border-radius:999px; font-size:13px; font-weight:700;">
                        {{ $appointment->status_label }}
                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection

<!-- CALENDAR MODAL -->
<div id="calendarModal" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    justify-content:center;
    align-items:center;
    z-index:9999;
">

    <div style="
        background:white;
        width:90%;
        max-width:900px;
        border-radius:12px;
        padding:20px;
        max-height:90vh;
        overflow:auto;
    ">

        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h2 style="margin:0;">📅 Calendar</h2>

            <button onclick="closeCalendar()" class="btn">Close</button>
        </div>

        <hr>

        <!-- GRID -->
        <div style="
            display:grid;
            grid-template-columns:repeat(7,1fr);
            gap:8px;
            margin-top:15px;
        ">

            <!-- DAY LABELS -->
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                <div style="font-weight:600;text-align:center;color:#64748b;">
                    {{ $day }}
                </div>
            @endforeach

            <!-- EMPTY OFFSET -->
            @for($i = 0; $i < $startOfMonth->dayOfWeek; $i++)
                <div></div>
            @endfor

            <!-- DAYS -->
            @foreach($daysInMonth as $day)

                @php
                    $dateKey = $day->format('Y-m-d');
                    $hasAppointments = isset($appointments[$dateKey]);
                @endphp

                <div style="
                    border:1px solid #e2e8f0;
                    border-radius:8px;
                    padding:10px;
                    min-height:60px;
                    text-align:center;
                    background: {{ $hasAppointments ? '#dbeafe' : 'white' }};
                    cursor:pointer;
                ">

                    <div style="font-weight:600;">
                        {{ $day->day }}
                    </div>

                    @if($hasAppointments)
                        <div style="
                            margin-top:5px;
                            font-size:12px;
                            color:#2563eb;
                        ">
                            {{ count($appointments[$dateKey]) }} appt
                        </div>
                    @endif

                </div>

            @endforeach

        </div>
    </div>
</div>

<script>
function openCalendar() {
    document.getElementById('calendarModal').style.display = 'flex';
}

function closeCalendar() {
    document.getElementById('calendarModal').style.display = 'none';
}
</script>