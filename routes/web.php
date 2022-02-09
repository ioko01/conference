<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\ManageResearchController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\EditFileUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\EditResearchController;

use Illuminate\Support\Facades\Auth;
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

// Email Verify
Route::get('email/verify', [MailController::class, 'verify'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [MailController::class, 'verify_id'])->middleware('signed')->name('verification.verify');
Route::post('email/verification-notification', [MailController::class, 'verify_notification'])->middleware('throttle:6,1')->name('verification.send');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function(){

    Route::get('download', [FileDownloadController::class, 'index'])->name('download');

    Route::prefix('employee')->group(function(){
        // ส่งบทความฉบับแก้ไข
        Route::get('research/send', [ResearchController::class, 'index'])->name('employee.research.index');
        Route::get('research/show/{topic_id}', [ResearchController::class, 'show'])->name('employee.research.show');
        Route::post('research/send/create', [ResearchController::class, 'store'])->name('employee.research.store');
        Route::get('research/edit/{topic_id}', [ResearchController::class, 'edit'])->name('employee.research.edit');
        Route::put('research/edit/{topic_id}/update', [ResearchController::class, 'update'])->name('employee.research.update');

        // ส่งบทความฉบับแก้ไข
        Route::get('research/send-edit/show/{id}', [EditResearchController::class, 'show'])->name('employee.research.send.edit');

        Route::put('payment/{payment_upload}/upload', [PaymentController::class, 'update'])->name('employee.payment.update');
        Route::post('payment/{payment_upload}/create', [PaymentController::class, 'store'])->name('employee.payment.store');
        
        Route::put('pdf/{pdf_upload}/upload', [PdfController::class, 'update'])->name('employee.pdf.update');
        Route::post('pdf/{pdf_upload}/create', [PdfController::class, 'store'])->name('employee.pdf.store');

        Route::put('word/{word_upload}/upload', [WordController::class, 'update'])->name('employee.word.update');
        Route::post('word/{word_upload}/create', [WordController::class, 'store'])->name('employee.word.store');

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