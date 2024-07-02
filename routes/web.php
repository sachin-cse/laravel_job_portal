<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\HomeController;
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
});

Route::group(['prefix'=>'job-portal', 'middleware'=>['auth']], function(){
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('user_dashboard');
    Route::post('/update-profile/{action_type}', [CandidateConrtoller::class, 'handleUpdaterequest'])->name('handle_profile_update_request');
});
