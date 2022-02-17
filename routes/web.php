<?php

use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/notifications/{slug}/status/{id}', function ($slug, $id) {
    $job = Job::getJobBySlugAndStatusOpen($slug);
    $application = Application::where('user_id', $id)->where('job_id', $job->id)->first();

    return view('notification', compact('job', 'application'));
})->name('notification');
