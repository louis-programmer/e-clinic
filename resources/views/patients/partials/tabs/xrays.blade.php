<div class="card">

    <h3>Patient X-Rays</h3>

    {{-- UPLOAD --}}
    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))

            <form action="{{ route('patients.images.store', $patient->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  style="margin-bottom:20px;">

                @csrf

                <input type="hidden" name="type" value="xray">

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="form-input">

                <button type="submit"
                        class="btn btn-primary"
                        style="margin-top:10px;">
                    Upload X-Ray
                </button>

            </form>

        @endif
    @endauth

</div>

{{-- GALLERY --}}
<div class="card" style="margin-top:20px;">

    <h3>X-Ray Gallery</h3>

    @php
        $xrays = $patient->images()->xrays()->get();
    @endphp

    @forelse($xrays as $image)

        <div style="display:inline-block; margin:8px; position:relative;">

            <img src="{{ asset('storage/' . $image->file_path) }}"
                 style="
                    width:220px;
                    height:220px;
                    object-fit:cover;
                    border-radius:10px;
                    cursor:pointer;
                    background:#000;
                 "
                 onclick="openModal(this.src)">

            {{-- DELETE --}}
            @auth
                @if(auth()->user()->hasAnyRole(...config('roles.patient_manage')))

                    <form method="POST"
                          action="{{ route('patients.images.destroy', $image->id) }}"
                          style="position:absolute; top:5px; right:5px;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Delete this X-Ray?')"
                                style="
                                    background:red;
                                    color:white;
                                    border:none;
                                    padding:4px 6px;
                                    border-radius:5px;
                                    cursor:pointer;
                                ">
                            ✕
                        </button>

                    </form>

                @endif
            @endauth

        </div>

    @empty
        <p>No X-Rays uploaded yet.</p>
    @endforelse

</div>