<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
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


Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('logout');

Route::get('/welcome', [AuthController::class, 'welcome'])->name('welcome')->middleware('auth');




Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('recaptcha');
Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verify.email')->middleware('signed');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('recaptcha');
Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code')->middleware('recaptcha');

