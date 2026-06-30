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
use App\Modules\Patients\Controllers\PatientImportController;
use App\Modules\Users\Controllers\UserController;
use App\Http\Controllers\LicenseController;



/*
|--------------------------------------------------------------------------
| AUTH (NO LICENSE CHECK YET)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // IMPORTANT: license pages must be accessible without middleware
    Route::get('/activate-license', function () {
        return view('license.activate');
    })->name('license.activate');

    Route::get('/license-expired', function () {
        return view('license.expired');
    })->name('license.expired');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED + LICENSE PROTECTED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'license'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/loading', function () {
        return view('loading');
    })->name('loading');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | REMINDERS
    |--------------------------------------------------------------------------
    */
    Route::post('/reminders', [ReminderController::class, 'store']);
    Route::post('/reminders/{reminder}/done', [ReminderController::class, 'markDone']);

    /*
    |--------------------------------------------------------------------------
    | PATIENTS MODULE
    |--------------------------------------------------------------------------
    */
    Route::prefix('patients')->group(function () {

        Route::get('/', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('/', [PatientController::class, 'store'])->name('patients.store');

        Route::get('/{patient}', [PatientController::class, 'show'])->name('patients.show');
        Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/{patient}', [PatientController::class, 'update'])->name('patients.update');

        /*
        | IMPORT
        */
        Route::get('/import', [PatientImportController::class, 'index'])->name('patients.import');
        Route::post('/import', [PatientImportController::class, 'store'])->name('patients.import.store');

        /*
        | PROGRESS NOTES
        */
        Route::post('/{patient}/progress-notes', [ProgressNoteController::class, 'store'])
            ->name('progress-notes.store');

        /*
        | CHECKOUT
        */
        Route::post('/{patient}/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');

        /*
        | IMAGES
        */
        Route::post('/{patient}/images', [PatientImageController::class, 'store'])
            ->name('patients.images.store');

        Route::delete('/images/{image}', [PatientImageController::class, 'destroy'])
            ->name('patients.images.destroy');

        /*
        | APPOINTMENTS
        */
        Route::post('/{patient}/appointments', [AppointmentController::class, 'store'])
            ->name('appointments.store');

        /*
        | FORMS
        */
        Route::post('/{patient}/forms', [FormController::class, 'store'])->name('forms.store');
        Route::get('/{patient}/forms/{form}/view', [FormController::class, 'view'])->name('forms.view');
        Route::delete('/{patient}/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

        /*
        | MEDICAL HISTORY
        */
        Route::post('/{patient}/medical-history', [MedicalHistoryController::class, 'store'])
            ->name('medical-history.store');

        Route::delete('/{patient}/medical-history/{history}', [MedicalHistoryController::class, 'destroy'])
            ->name('medical-history.destroy');

        /*
        | DENTAL CHART
        */
        Route::get('/{patient}/dental-chart', [DentalChartController::class, 'index'])
            ->name('dental-chart.index');

        Route::post('/{patient}/dental-chart', [DentalChartController::class, 'store'])
            ->name('dental-chart.store');
    });

    /*
    |--------------------------------------------------------------------------
    | APPOINTMENTS (GLOBAL)
    |--------------------------------------------------------------------------
    */
    Route::prefix('appointments')->group(function () {

        Route::post('{appointment}/no-show', [AppointmentController::class, 'noShow'])->name('appointments.no-show');
        Route::post('{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::post('{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
        Route::post('{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
        Route::delete('{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ENCOUNTERS
    |--------------------------------------------------------------------------
    */
    Route::prefix('encounters')->group(function () {
        Route::post('/patients/{patient}', [EncounterController::class, 'store'])->name('encounters.store');
        Route::get('/{encounter}/edit', [EncounterController::class, 'edit'])->name('encounters.edit');
        Route::put('/{encounter}', [EncounterController::class, 'update'])->name('encounters.update');
    });

    /*
    |--------------------------------------------------------------------------
    | INVOICES + PAYMENTS
    |--------------------------------------------------------------------------
    */
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/invoices/{invoice}/void', [InvoiceController::class, 'void'])->name('invoices.void');

    /*
    |--------------------------------------------------------------------------
    | SCAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('scan')->group(function () {
        Route::get('/', [ScanController::class, 'index'])->name('scan.index');
        Route::post('/', [ScanController::class, 'store'])->name('scan.store');
    });

    /*
    |--------------------------------------------------------------------------
    | CLINIC PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/clinic-profile', [ClinicProfileController::class, 'edit'])
        ->name('clinic-profile.edit');

    Route::post('/clinic-profile', [ClinicProfileController::class, 'update'])
        ->name('clinic-profile.update');

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
    });
});



/*
|--------------------------------------------------------------------------
| License Pages
|--------------------------------------------------------------------------
*/



Route::get('/activate-license', [LicenseController::class, 'show'])
    ->name('license.activate');

Route::post('/activate-license', [LicenseController::class, 'activate'])
    ->name('license.activate.store');

Route::get('/license-expired', function () {
    return view('license.expired');
})->name('license.expired');