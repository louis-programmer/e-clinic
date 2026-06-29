@extends('layouts.app')

@section('content')

<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:15px;
    ">

        <div>
            <h2 style="margin:0;">
                Users
            </h2>

            <div style="color:#64748b;">
                Manage system users
            </div>
        </div>

        <a
            href="{{ route('users.create') }}"
            class="btn"
        >
            + New User
        </a>

    </div>


    <form method="GET" style="margin-bottom:20px;">

        <input
            type="text"
            name="search"
            placeholder="Search user..."
            value="{{ $search }}"
            class="form-input"
            style="max-width:350px;"
        >

    </form>


    <table style="
        width:100%;
        border-collapse:collapse;
    ">

        <thead>

            <tr style="border-bottom:1px solid #e2e8f0;">

                <th style="text-align:left;padding:12px;">
                    Username
                </th>

                <th style="text-align:left;padding:12px;">
                    Name
                </th>

                <th style="text-align:left;padding:12px;">
                    Email
                </th>

                <th style="text-align:left;padding:12px;">
                    Role
                </th>

                <th style="text-align:center;padding:12px;">
                    Actions
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($users as $user)

            <tr style="border-bottom:1px solid #f1f5f9;">

                <td style="padding:12px;">
                    {{ $user->username }}
                </td>

                <td style="padding:12px;">
                    {{ $user->name }}
                </td>

                <td style="padding:12px;">
                    {{ $user->email }}
                </td>

                <td style="padding:12px;">

                    @foreach($user->roles as $role)

                        <span style="
                            display:inline-block;
                            background:#eff6ff;
                            color:#2563eb;
                            padding:4px 10px;
                            border-radius:999px;
                            font-size:12px;
                            font-weight:600;
                            margin-right:4px;
                        ">
                            {{ ucfirst($role->name) }}
                        </span>

                    @endforeach

                </td>

                <td style="
                    padding:12px;
                    text-align:center;
                ">

                    Coming Soon

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="5"
                    style="
                        text-align:center;
                        padding:30px;
                        color:#64748b;
                    "
                >
                    No users found.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    <div style="margin-top:20px;">

        {{ $users->links() }}

    </div>

</div>

@endsection