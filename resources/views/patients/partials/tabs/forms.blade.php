<div class="card">

    <h3>Patient Forms</h3>

    {{-- ================= FORM UPLOAD ================= --}}
    <form method="POST"
          action="{{ route('forms.store', $patient->id) }}"
          enctype="multipart/form-data">

        @csrf

        <div>
            <label>Form Title</label>
            <input type="text" name="title" class="form-input" required>
        </div>

        <div>
            <label>Category</label>
            <select name="category" class="form-input" required>
                <option>Consent Form</option>
                <option>Medical Clearance</option>
                <option>X-Ray</option>
                <option>Lab Result</option>
                <option>Prescription</option>
                <option>Referral</option>
                <option>Insurance</option>
                <option>Other</option>
            </select>
        </div>

        <div>
            <label>Remarks</label>
            <textarea name="remarks" class="form-input"></textarea>
        </div>

        <div>
            <label>File</label>
            <input type="file" name="file" class="form-input" required>
        </div>

        <button type="submit" class="btn btn-primary">
            + Save Form
        </button>

    </form>
</div>





{{-- ================= LIST ================= --}}
<div class="card" style="margin-top:20px;">

    <h3>Uploaded Forms</h3>

    @forelse($patient->forms as $form)

        <div style="padding:15px; border:1px solid #ddd; margin-bottom:10px;">

            <div>
                <strong>{{ $form->title }}</strong>
            </div>

            <div>
                Category: {{ $form->category }}
            </div>

            <div>
                {{ $form->remarks }}
            </div>

            <div style="margin-top:10px; display:flex; gap:10px;">

                {{-- VIEW FILE (SECURE PATIENT-SCOPED ROUTE) --}}
                <a href="{{ route('forms.view', [$patient->id, $form->id]) }}"
                   target="_blank">

                    View
                </a>

                {{-- DELETE FORM (SECURE PATIENT-SCOPED ROUTE) --}}
                <form method="POST"
                      action="{{ route('forms.destroy', [$patient->id, $form->id]) }}"
                      style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="color:red; background:none; border:none; cursor:pointer;">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    @empty
        <p>No forms uploaded yet.</p>
    @endforelse

</div>