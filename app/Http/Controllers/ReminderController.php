<?php

namespace App\Http\Controllers;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required|string|max:1000'
        ]);

        Reminder::create([
            'user_id' => auth()->id(),
            'note' => $request->note,
            'status' => 'pending'
        ]);

        return back();
    }

    public function markDone(Reminder $reminder)
    {
        abort_unless($reminder->user_id === auth()->id(), 403);

        $reminder->update([
            'status' => 'done'
        ]);

        return back();
    }
}