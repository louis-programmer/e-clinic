<?php

namespace App\Http\Controllers;

use App\Modules\Patients\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $todayAppointments = Appointment::with('patient')
            ->today()
            ->orderBy('appointment_date')
            ->get();

        $scheduledCount = $todayAppointments->count();

        return view('dashboard', compact(
            'todayAppointments',
            'scheduledCount'
        ));
    }
}