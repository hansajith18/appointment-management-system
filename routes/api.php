<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

/**
 * @Auth-Routes
 * http://localhost:8000/api/auth/
 */
Route::group(['prefix' => 'auth', 'middleware' => ['auth:sanctum']], function () {
    Route::post('patient-details/{patient:external_patient_id}', [PatientController::class, 'getPatientDetails']);
});
