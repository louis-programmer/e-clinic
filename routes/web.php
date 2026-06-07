<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;

use App\Modules\Patients\Controllers\PatientController;
use App\Modules\Patients\Controllers\PatientImageController;
use App\Modules\Forms\Controllers\FormController;
use App\Modules\Patients\Controllers\MedicalHistoryController;
use App\Http\Controllers\ReminderController;
use App\Modules\Patients\Controllers\ProgressNoteController;
use App\Modules\Patients\Controllers\CheckoutController;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;

use App\Modules\Patients\Controllers\DentalChartController;

use App\Http\Controllers\ClinicProfileController;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/loading', function () {
        return view('loading');
    })->name('loading');

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::post('/reminders', [ReminderController::class, 'store']);
    Route::post('/reminders/{reminder}/done', [ReminderController::class, 'markDone']);

    /*
    |--------------------------------------------------------------------------
    | Patients
    |--------------------------------------------------------------------------
    */
    Route::prefix('patients')->group(function () {

        Route::get('/', [PatientController::class, 'index'])
            ->name('patients.index');

        Route::get('/create', [PatientController::class, 'create'])
            ->name('patients.create');

        Route::post('/', [PatientController::class, 'store'])
            ->name('patients.store');

        Route::get('/{patient}', [PatientController::class, 'show'])
            ->name('patients.show');

        Route::get('/{patient}/edit', [PatientController::class, 'edit'])
            ->name('patients.edit');

        Route::put('/{patient}', [PatientController::class, 'update'])
            ->name('patients.update');


        /*
        |--------------------------------------------------------------------------
        | Progress Notes (FIXED)
        |--------------------------------------------------------------------------
        */
        Route::post('/{patient}/progress-notes', [ProgressNoteController::class, 'store'])
            ->name('progress-notes.store');



        /*
        |--------------------------------------------------------------------------
        |Checkout
        |--------------------------------------------------------------------------
        */

        Route::post('/{patient}/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');
    

        /*
        |--------------------------------------------------------------------------
        | Patient Images
        |--------------------------------------------------------------------------
        */
        Route::post('/{patient}/images', [PatientImageController::class, 'store'])
            ->name('patients.images.store');

        Route::delete('/images/{image}', [PatientImageController::class, 'destroy'])
            ->name('patients.images.destroy');

        /*
        |--------------------------------------------------------------------------
        | Patient Appointments
        |--------------------------------------------------------------------------
        */
        Route::post('/{patient}/appointments', [AppointmentController::class, 'store'])
            ->name('appointments.store');

        /*
        |--------------------------------------------------------------------------
        | Patient Forms
        |--------------------------------------------------------------------------
        */
        Route::post('/{patient}/forms', [FormController::class, 'store'])
            ->name('forms.store');

        Route::get('/{patient}/forms/{form}/view', [FormController::class, 'view'])
            ->name('forms.view');

        Route::delete('/{patient}/forms/{form}', [FormController::class, 'destroy'])
            ->name('forms.destroy');

        /*
        |--------------------------------------------------------------------------
        | Medical History
        |--------------------------------------------------------------------------
        */
        Route::post('/{patient}/medical-history', [MedicalHistoryController::class, 'store'])
            ->name('medical-history.store');

        Route::delete('/{patient}/medical-history/{history}', [MedicalHistoryController::class, 'destroy'])
            ->name('medical-history.destroy');



        /*
        |--------------------------------------------------------------------------
        | Dental Chart
        |--------------------------------------------------------------------------
        */

          Route::get(
                '/{patient}/dental-chart',
                [DentalChartController::class, 'index']
            )->name('dental-chart.index');


            Route::post('/{patient}/dental-chart', [DentalChartController::class, 'store'])
    ->name('dental-chart.store');

    });



    /*
    |--------------------------------------------------------------------------
    | Appointment Actions
    |--------------------------------------------------------------------------
    */
    Route::prefix('appointments')->group(function () {

        Route::post('{appointment}/no-show', [AppointmentController::class, 'noShow'])
            ->name('appointments.no-show');

        Route::post('{appointment}/cancel', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');

        Route::post('{appointment}/complete', [AppointmentController::class, 'complete'])
            ->name('appointments.complete');

        Route::post('{appointment}/reschedule', [AppointmentController::class, 'reschedule'])
            ->name('appointments.reschedule');

        Route::delete('{appointment}', [AppointmentController::class, 'destroy'])
            ->name('appointments.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Encounters
    |--------------------------------------------------------------------------
    */
    Route::prefix('encounters')->group(function () {

        Route::post('/patients/{patient}', [EncounterController::class, 'store'])
            ->name('encounters.store');

        Route::get('/{encounter}/edit', [EncounterController::class, 'edit'])
            ->name('encounters.edit');

        Route::put('/{encounter}', [EncounterController::class, 'update'])
            ->name('encounters.update');
    });



    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])
    ->name('invoices.show');

    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store'])
    ->name('payments.store');

    /*
    |--------------------------------------------------------------------------
    | Scan
    |--------------------------------------------------------------------------
    */
    Route::prefix('scan')->group(function () {

        Route::get('/', [ScanController::class, 'index'])
            ->name('scan.index');

        Route::post('/', [ScanController::class, 'store'])
            ->name('scan.store');
    });




    /*
    |--------------------------------------------------------------------------
    | Clinic Profile
    |--------------------------------------------------------------------------
    */
        Route::get(
            '/clinic-profile',
            [ClinicProfileController::class, 'edit']
        );

        Route::post(
            '/clinic-profile',
            [ClinicProfileController::class, 'update']
        );



});