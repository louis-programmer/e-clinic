<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Modules\Patients\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Today Appointments
        |--------------------------------------------------------------------------
        */
        $todayAppointments = Appointment::with('patient')
            ->today()
            ->orderBy('appointment_date')
            ->get();

        $scheduledCount = $todayAppointments->count();

        /*
        |--------------------------------------------------------------------------
        | Calendar Range (Current Month)
        |--------------------------------------------------------------------------
        */
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | Monthly Appointments
        |--------------------------------------------------------------------------
        */
        $appointmentsRaw = Appointment::whereBetween('appointment_date', [
                $startOfMonth,
                $endOfMonth
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SAFE GROUPING (Carbon safety fix)
        |--------------------------------------------------------------------------
        */
        $appointments = $appointmentsRaw->groupBy(function ($item) {
            return optional($item->appointment_date)
                ? $item->appointment_date->format('Y-m-d')
                : null;
        });

        /*
        |--------------------------------------------------------------------------
        | Calendar Days
        |--------------------------------------------------------------------------
        */
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