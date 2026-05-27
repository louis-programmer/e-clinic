<?php

namespace App\Http\Controllers;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{

    public function __construct()
{
    $this->middleware('auth');
}


public function store(Request $request)
{
    $data = $request->validate([
        'note' => ['required', 'string', 'max:1000'],
    ]);

    Reminder::create([
        'user_id' => auth()->id(),
        'note' => $data['note'],
        'status' => 'pending',
    ]);

    return back();
}
public function markDone(Reminder $reminder)
{
    abort_if($reminder->user_id !== auth()->id(), 403);

    $reminder->update([
        'status' => 'done'
    ]);

    return back();
}
}