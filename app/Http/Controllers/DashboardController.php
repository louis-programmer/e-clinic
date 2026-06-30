<?php
/*
### Documented

### uses:
    -DashboardController.php
    -Invoice.php
    -InvoiceController.php
    -Payment.php
    -PaymemntController.php
    -add.blade.php
    


*/
namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Modules\Patients\Models\Appointment;
use App\Modules\Patients\Models\Patient;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

$clinicId = auth()->user()->clinic_id;

/*
|--------------------------------------------------------------------------
| Patient Statistics
|--------------------------------------------------------------------------
*/

$totalPatients = Patient::where(
    'clinic_id',
    $clinicId
)->count();

$newPatientsThisMonth = Patient::where(
    'clinic_id',
    $clinicId
)
->whereYear('created_at', now()->year)
->whereMonth('created_at', now()->month)
->count();

$newPatientsLastSixMonths = Patient::where(
    'clinic_id',
    $clinicId
)
->where(
    'created_at',
    '>=',
    now()->subMonths(6)
)
->count();

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
            $todayAppointments = Appointment::with('patient')
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
        $appointmentsRaw = Appointment::with('patient')
            ->whereHas('patient', function ($q) {
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
            return $item->appointment_date
                ? $item->appointment_date->format('Y-m-d')
                : null;
        });



     /*
                |--------------------------------------------------------------------------
                | FINANCIAL METRICS
                |--------------------------------------------------------------------------
                */

                $todayRevenue = \App\Models\Payment::whereDate('created_at', today())
                    ->whereHas('invoice.patient', function ($q) use ($clinicId) {
                        $q->where('clinic_id', $clinicId);
                    })
                    ->sum('amount');

                $unpaidInvoices = \App\Models\Invoice::whereHas('patient', function ($q) use ($clinicId) {
                            $q->where('clinic_id', $clinicId);
                        })
                        ->where('is_void', false)
                        ->where('status', '!=', 'paid')
                        ->count();

                            // making invoices metrics upgrade
                        $unpaidInvoiceList = \App\Models\Invoice::with('patient')
                            ->whereHas('patient', function ($q) use ($clinicId) {
                                $q->where('clinic_id', $clinicId);
                            })
                            ->where('is_void', false)
                            ->where('status', '!=', 'paid')
                            ->orderBy('created_at')
                            ->get();
   

                $totalOutstandingBalance = \App\Models\Invoice::whereHas('patient', function ($q) use ($clinicId) {
                        $q->where('clinic_id', $clinicId);
                    })
                    ->where('is_void', false)
                    ->sum('balance');


                        
                /*
                |--------------------------------------------------------------------------
                | FINANCE - LAST 6 MONTHS
                |--------------------------------------------------------------------------
                */

                $monthlyRevenueLast6Months = \App\Models\Payment::select(
                        DB::raw("SUM(amount) as total"),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
                    )
                    ->whereDate('created_at', '>=', Carbon::now()->subMonths(6))
                    ->whereHas('invoice.patient', function ($q) use ($clinicId) {
                        $q->where('clinic_id', $clinicId);
                    })
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();



                        /*
                |--------------------------------------------------------------------------
                | CLINICAL METRICS
                |--------------------------------------------------------------------------
                */

                $patientsSeenToday = \App\Modules\Patients\Models\Appointment::whereHas(
                    'patient',
                    function ($q) use ($clinicId) {
                        $q->where('clinic_id', $clinicId);
                    }
                )
                ->whereDate('appointment_date', today())
                ->where('status', 'completed')
                ->count();






                        /*
                |--------------------------------------------------------------------------
                | top treatments
                |--------------------------------------------------------------------------
                */
/*
                    $topTreatments = \App\Models\InvoiceItem::select(
                        'procedure_id',
                        DB::raw('SUM(line_total) as revenue'),
                        DB::raw('COUNT(*) as count')
                    )
                    ->with('procedure')
                    ->whereHas('invoice.patient', function ($q) use ($clinicId) {
                        $q->where('clinic_id', $clinicId);
                    })
                    ->groupBy('procedure_id')
                    ->orderByDesc('revenue')
                    ->limit(5)
                    ->get();

*/
                       $topTreatments = \App\Models\InvoiceItem::select(
                            'procedure_id',
                            DB::raw('SUM(line_total) as revenue'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->whereHas('invoice', function ($q) {
                            $q->where('is_void', false);
                        })
                        ->whereHas('invoice.patient', function ($q) use ($clinicId) {
                            $q->where('clinic_id', $clinicId);
                        })
                        ->groupBy('procedure_id')
                        ->orderByDesc('revenue')
                        ->limit(5)
                        ->get();

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
                'birthdayPatients',
                 'totalPatients',
                'newPatientsThisMonth',
                'newPatientsLastSixMonths',
                'todayRevenue',
                'unpaidInvoices',
                'unpaidInvoiceList',   // ← ADD THIS
                'totalOutstandingBalance',
                'patientsSeenToday',
                'monthlyRevenueLast6Months',
                'topTreatments'

            ));



           

    }
}