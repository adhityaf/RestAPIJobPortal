<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompanyApplicationController;
use App\Http\Controllers\API\ApplicantApplicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Can be access when user is authenticated
Route::prefix('/v1.0')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        // Can be access for applicant only 
        Route::middleware(['applicant'])->group(function () {

            Route::get('/applicants', [ApplicantApplicationController::class, 'index']);
            Route::post('/applicants/{slug}', [ApplicantApplicationController::class, 'sendApplication']);

        });

        // Can be access for company only 
        Route::middleware(['company'])->group(function () {

            Route::post('/jobs', [JobController::class, 'store']);
            Route::put('/jobs/{slug}', [JobController::class, 'update']);
            Route::delete('/jobs/{slug}', [JobController::class, 'destroy']);

            // list all applicant based on job slug
            Route::get('/companies/{slug}', [CompanyApplicationController::class, 'listApplicant']);

            // change status application
            Route::patch('/companies/{slug}/interview/{id}', [CompanyApplicationController::class, 'changeStatusToInterview']);
            Route::patch('/companies/{slug}/offered/{id}', [CompanyApplicationController::class, 'changeStatusToOffered']);
            Route::patch('/companies/{slug}/hired/{id}', [CompanyApplicationController::class, 'changeStatusToHired']);
            Route::patch('/companies/{slug}/unsuitable/{id}', [CompanyApplicationController::class, 'changeStatusToUnsuitable']);



            // The app has review candidates page for the company
            // Route::get('/companies/{id}', [CompanyApplicationController::class, 'checkApplication']);
            // Route::patch('/companies/{id}', [CompanyApplicationController::class, 'changeStatusApplication']);
        });

        Route::get('/logout', [AuthController::class, 'logout']);
    });
    
    // Didn't have to authenticated
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Can be access for both role 
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/{slug}', [JobController::class, 'show']);
});
