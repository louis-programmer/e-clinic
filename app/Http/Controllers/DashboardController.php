<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

        // ==============================
        // CALENDAR DATA (CURRENT MONTH)
        // ==============================
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $appointments = Appointment::whereBetween('appointment_date', [
                $startOfMonth,
                $endOfMonth
            ])
            ->get()
            ->groupBy(function ($item) {
                return $item->appointment_date->format('Y-m-d');
            });

        $daysInMonth = CarbonPeriod::create($startOfMonth, '1 day', $endOfMonth);

        return view('dashboard', compact(
            'todayAppointments',
            'scheduledCount',
            'appointments',
            'daysInMonth',
            'startOfMonth'
        ));
    }


}