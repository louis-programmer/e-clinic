<div class="card">

    <h3>Patient Photos</h3>

    {{-- UPLOAD --}}
    @auth
        @if(auth()->user()->hasAnyRole(...config('roles.patient_photos')))

            <form action="{{ route('patients.images.store', $patient->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  style="margin-bottom:20px;">

                @csrf
                <input type="hidden"
                   name="type"
                   value="photo">

                <input type="file"
                       name="image"
                       accept="image/*"
                       class="form-input">

                <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                    Upload Image
                </button>

            </form>

        @endif
    @endauth

</div>


{{-- GALLERY --}}
<div class="card" style="margin-top:20px;">

    <h3>Gallery</h3>

    @php
        $photos = $patient->images->where('type', 'photo');
    @endphp

    @forelse($photos as $image)

        <div style="
            display:inline-block;
            margin:8px;
            position:relative;
        ">

            <img src="{{ asset('storage/' . $image->file_path) }}"
                 style="
                    width:180px;
                    height:180px;
                    object-fit:cover;
                    border-radius:10px;
                    cursor:pointer;
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
                                onclick="return confirm('Delete this image?')"
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
        <p>No images uploaded yet.</p>
    @endforelse

</div>