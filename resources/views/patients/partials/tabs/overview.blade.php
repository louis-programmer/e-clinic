<div class="card">

    <h3>Medical History</h3>

    <p style="color:#64748b;">
        Record of patient medical conditions and history.
    </p>

</div>


<div class="card" style="margin-top:20px;">

    <h3>Add Medical Condition</h3>

    <form method="POST">

        @csrf

        <label>Condition</label>
        <input type="text" name="condition_name" class="form-input">

        <label>Status</label>
        <select name="status" class="form-input">
            <option value="active">Active</option>
            <option value="resolved">Resolved</option>
            <option value="chronic">Chronic</option>
        </select>

        <label>Notes</label>
        <textarea name="notes" class="form-input"></textarea>

        <button class="btn btn-primary">Add Condition</button>

    </form>

</div>


<div class="card" style="margin-top:20px;">

    <h3>Conditions</h3>

    <p>No medical history recorded yet.</p>

</div>