<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



//Email Verify Notification
Route::get('email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

//Email Verify Handle
Route::get('email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware('signed')->name('verification.verify');

//Resend Email Verify
Route::post('email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware('throttle:6,1')->name('verification.send');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function(){
    Route::prefix('employee')->group(function(){
        Route::resource('research', ResearchController::class, ['names' => 'employee.research']);
        Route::resource('file-upload', FileUploadController::class, ['names' => 'employee.file-upload']);
    });
});
       

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');