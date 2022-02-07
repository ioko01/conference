<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ManageResearchController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\EditFileUploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

Route::get('contract', function () {
    return view('frontend.pages.contract');
})->name('contract');

Route::get('payment', [PaymentController::class, 'index'])->name('payment');


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

    Route::get('download', [FileDownloadController::class, 'index'])->name('download');

    Route::prefix('employee')->group(function(){
        Route::resource('research/edit', ResearchController::class, ['names' => 'employee.research.edit']);
        Route::resource('research', ResearchController::class, ['names' => 'employee.research']);

        Route::put('file-upload/{file_upload}', [FileUploadController::class, 'update'])->name('employee.file-upload.update');
    });

    Route::middleware('is_admin')->group(function(){
        Route::get('generate', function (){
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            echo 'ok';
        });
        Route::prefix('admin')->group(function(){
            Route::prefix('research')->group(function(){
                Route::resource('/', ManageResearchController::class, ['names' => 'admin.research']);
                Route::put('create-editresearch-upload/{topic_id}', [EditFileUploadController::class, 'update']);
            });
        });
    });
});
       

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');