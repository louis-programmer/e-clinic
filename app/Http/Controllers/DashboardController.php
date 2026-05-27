<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Modules\Patients\Models\Appointment;
use App\Modules\Patients\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {

$clinicId = auth()->user()->clinic_id;
                /*
        |--------------------------------------------------------------------------
        | Today Birthday
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $birthdayPatients = Patient::query()
            ->where('clinic_id', auth()->user()->clinic_id)
            ->whereMonth('birthdate', $today->month)
            ->whereDay('birthdate', $today->day)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Today Appointments
        |--------------------------------------------------------------------------
        */
$todayAppointments = Appointment::with(['patient' => function ($q) use ($clinicId) {
        $q->where('clinic_id', $clinicId);
    }])
    ->whereHas('patient', function ($q) use ($clinicId) {
        $q->where('clinic_id', $clinicId);
    })
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
        $appointmentsRaw = Appointment::whereHas('patient', function ($q) {
                $q->where('clinic_id', auth()->user()->clinic_id);
            })
            ->whereBetween('appointment_date', [
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
                'startOfMonth',
                'birthdayPatients'
            ));
    }
}