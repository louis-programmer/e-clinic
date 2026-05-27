<div class="tooth-wrapper">

    <div class="tooth-number">
        {{ $tooth }}
    </div>

    <div class="tooth-grid">

        {{-- TOP --}}
        <div
            class="surface top"
            data-tooth="{{ $tooth }}"
            data-side="top"
        ></div>

        {{-- LEFT --}}
        <div
            class="surface left"
            data-tooth="{{ $tooth }}"
            data-side="left"
        ></div>

        {{-- CENTER --}}
        <div
            class="surface center"
            data-tooth="{{ $tooth }}"
            data-side="center"
        ></div>

        {{-- RIGHT --}}
        <div
            class="surface right"
            data-tooth="{{ $tooth }}"
            data-side="right"
        ></div>

        {{-- BOTTOM --}}
        <div
            class="surface bottom"
            data-tooth="{{ $tooth }}"
            data-side="bottom"
        ></div>

    </div>

</div>