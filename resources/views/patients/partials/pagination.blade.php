<div style="
    display:flex;
    justify-content:center;
    align-items:center;
    gap:6px;
    margin-top:20px;
    flex-wrap:wrap;
">

    {{-- Previous --}}
    @if ($patients->onFirstPage())
        <span style="
            padding:6px 12px;
            border:1px solid #e2e8f0;
            border-radius:6px;
            color:#94a3b8;
            background:#f8fafc;
        ">
            Previous
        </span>
    @else
        <a href="{{ $patients->previousPageUrl() }}"
           style="
                padding:6px 12px;
                border:1px solid #cbd5e1;
                border-radius:6px;
                text-decoration:none;
                color:#334155;
                background:white;
           ">
            Previous
        </a>
    @endif

    {{-- Page Numbers --}}
    @for ($i = 1; $i <= $patients->lastPage(); $i++)
        <a href="{{ $patients->url($i) }}"
           style="
                padding:6px 12px;
                border:1px solid #cbd5e1;
                border-radius:6px;
                text-decoration:none;
                font-weight:600;
                color:{{ $patients->currentPage() == $i ? 'white' : '#334155' }};
                background:{{ $patients->currentPage() == $i ? '#2563eb' : 'white' }};
           ">
            {{ $i }}
        </a>
    @endfor

    {{-- Next --}}
    @if ($patients->hasMorePages())
        <a href="{{ $patients->nextPageUrl() }}"
           style="
                padding:6px 12px;
                border:1px solid #cbd5e1;
                border-radius:6px;
                text-decoration:none;
                color:#334155;
                background:white;
           ">
            Next
        </a>
    @else
        <span style="
            padding:6px 12px;
            border:1px solid #e2e8f0;
            border-radius:6px;
            color:#94a3b8;
            background:#f8fafc;
        ">
            Next
        </span>
    @endif

</div>