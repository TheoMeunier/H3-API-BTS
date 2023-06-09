<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\ApiAppointmentController;
use App\Http\Controllers\ApiDoctorController;
use App\Http\Controllers\ApiProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [ApiAuthController::class, 'logout']);

    Route::controller(ApiProfileController::class)->prefix('/profile')->group(function () {
        Route::get('/', 'index');
        Route::post('/edit', 'update');
        Route::post('/edit/password', 'updatePassword');
        Route::post('/edit/information', 'updateInformation');
        Route::post('/delete', 'delete');
    });

    Route::controller(ApiDoctorController::class)->prefix('/doctors')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

    Route::controller(ApiAppointmentController::class)->prefix('/appoints')->group(function () {
        Route::get('/doctors', 'allByDoctor');
        Route::post('/create', 'add');

        Route::get('/past', 'past');
        Route::get('/future', 'futur');
    });
});
