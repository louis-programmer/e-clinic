<?php

use App\Http\Controllers\AuthController;
use App\Modules\Patients\Controllers\PatientController;
    use App\Http\Controllers\EncounterController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Patients Module
    |--------------------------------------------------------------------------
    */
    Route::prefix('patients')->group(function () {

        Route::get('/', [PatientController::class, 'index']);
        Route::get('/create', [PatientController::class, 'create']);
        Route::post('/', [PatientController::class, 'store']);

        Route::get('/{id}', [PatientController::class, 'show']);
        Route::get('/{id}/edit', [PatientController::class, 'edit']);
        Route::put('/{id}', [PatientController::class, 'update']);
    });




    Route::post('/patients/{id}/encounters', [EncounterController::class, 'store']);

});