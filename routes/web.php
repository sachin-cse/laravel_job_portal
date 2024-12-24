<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Job\JobdetailsController;
use App\Http\Controllers\Candidate\SearchController;
use App\Http\Controllers\Candidate\CandidateConrtoller;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index']);
Route::group(['prefix'=>'job-portal', 'middleware'=>['guest']], function(){
    Route::get('/{user_type}/register',[AuthController::class, 'index'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegisterrequest'])->name('handle_register_request');
    Route::get('/login', [AuthController::class, 'login_view'])->name('login_view');
    Route::post('/login', [AuthController::class, 'handleLoginrequest'])->name('handle_login_request');
    Route::post('/logout', [AuthController::class, 'handleLogoutrequest'])->name('handle_logout_request');
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('forgot_password');
    Route::post('/forgot-password/{token?}', [AuthController::class, 'handleForgotPassword'])->name('send_reset_link');

    Route::get('/reset-password/{token}', [AuthController::class, 'resetLinkView'])->name('reset_password_view');
    Route::post('/reset-password/{token}', [AuthController::class, 'handleResetPassword'])->name('handle_reset_password');
});

Route::group(['prefix'=>'job-portal', 'middleware'=>['auth']], function(){
    Route::get('/my-account', [HomeController::class, 'dashboard'])->name('user_dashboard');
    Route::get('/my-saved-jobs', [CandidateConrtoller::class, 'MySavedJobs'])->name('my_saved_jobs');
    Route::post('/my-saved-jobs/{action_type}', [CandidateConrtoller::class, 'handleMySavedJobRequest'])->name('handle_my_saved_jobs');
    Route::post('/saved-job', [CandidateConrtoller::class, 'savedJob'])->name('saved_job');
    Route::post('/update-profile/{action_type}', [CandidateConrtoller::class, 'handleUpdaterequest'])->name('handle_profile_update_request');

    // job details
    Route::get('/job-details/{job_type}', [JobdetailsController::class, 'jobDetails'])->name('job_details');
   
    Route::get('/{page}', [CandidateConrtoller::class, 'jobApply'])->name('job_apply');

    // handle search request
    Route::post('/find-jobs/filter/{order}', [SearchController::class, 'handleSearchRequest'])->name('handle_search_request');
});