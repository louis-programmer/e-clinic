@extends('layouts.app')

@section('content')

<div class="card">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        flex-wrap:wrap;
        margin-bottom:20px;
    ">

        {{-- LEFT SIDE --}}
        <div style="
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        ">

            <h1 style="margin:0;">
                Patients
            </h1>

            @auth
                @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))

                    <a href="/patients/create"
                       class="btn">
                        + Add Patient
                    </a>

                @endif
            @endauth

        </div>





        {{-- RIGHT SIDE --}}
        <div style="
            display:flex;
            gap:10px;
            align-items:center;
            flex-wrap:wrap;
        ">

            {{-- SEARCH --}}
            <input type="text"
                   placeholder="Search patient..."
                   class="form-input"
                   style="
                        width:220px;
                        margin:0;
                   ">





            {{-- CALENDAR BUTTON --}}
            <button class="btn"
                    style="
                        display:flex;
                        align-items:center;
                        gap:6px;
                    ">
                📅 Calendar
            </button>

        </div>

    </div>





    {{-- ===================================================== --}}
    {{-- PATIENT LIST --}}
    {{-- ===================================================== --}}
    @forelse ($patients as $patient)

        <div class="card"
             style="
                margin-bottom:14px;
                padding:18px;
             ">

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:20px;
                flex-wrap:wrap;
            ">




                {{-- LEFT SECTION --}}
                <div style="
                    display:flex;
                    align-items:center;
                    gap:16px;
                    flex:1;
                    min-width:260px;
                ">

                    {{-- PROFILE IMAGE --}}
                    <div>

                        @if(($patient->images ?? collect())->count())

                            <img src="{{ asset('storage/' . $patient->images->first()->file_path) }}"
                                 style="
                                    width:64px;
                                    height:64px;
                                    border-radius:50%;
                                    object-fit:cover;
                                    border:3px solid #e2e8f0;
                                 ">

                        @else

                            <div style="
                                width:64px;
                                height:64px;
                                border-radius:50%;
                                background:#e2e8f0;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:22px;
                                color:#64748b;
                            ">
                                👤
                            </div>

                        @endif

                    </div>





                    {{-- PATIENT INFO --}}
                    <div>

                        <a href="/patients/{{ $patient->id }}"
                           style="
                                text-decoration:none;
                                color:#0f172a;
                           ">

                            <div style="
                                font-size:18px;
                                font-weight:700;
                                margin-bottom:4px;
                            ">
                                {{ $patient->first_name }}
                                {{ $patient->last_name }}
                            </div>

                        </a>





                        <div style="
                            color:#64748b;
                            font-size:14px;
                            margin-bottom:4px;
                        ">
                            {{ $patient->contact_number }}
                        </div>





                        <div style="
                            display:flex;
                            gap:14px;
                            flex-wrap:wrap;
                            font-size:13px;
                            color:#475569;
                        ">

                            {{-- LAST VISIT --}}
                            <div>
                                <strong>Last Visit:</strong>
                                —
                            </div>

                            {{-- BALANCE --}}
                            <div>
                                <strong>Balance:</strong>
                                ₱0.00
                            </div>

                        </div>

                    </div>

                </div>





                {{-- RIGHT SECTION --}}
                <div style="
                    display:flex;
                    gap:10px;
                    align-items:center;
                    flex-wrap:wrap;
                ">

                    <a href="/patients/{{ $patient->id }}"
                       class="btn">
                        Open
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div style="
            background:#f8fafc;
            border-radius:10px;
            padding:40px;
            text-align:center;
            color:#64748b;
        ">
            No patients found.
        </div>

    @endforelse

</div>

@endsection