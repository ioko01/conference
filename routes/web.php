<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\ManageResearchController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\CommentFileUploadController;
use App\Http\Controllers\Backend\ConferenceController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DownloadController;
use App\Http\Controllers\Backend\ResearchController as BackendResearchController;
use App\Http\Controllers\Backend\StatementController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ListAttendController;
use App\Http\Controllers\ListResearchController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SendEditResearchController;
use App\Http\Controllers\SendEditWordController;
use App\Http\Controllers\SendEditPdfController;
use App\Http\Controllers\SendEditPdfTwoController;
use App\Http\Controllers\SendEditResearchTwoController;
use App\Http\Controllers\SendEditStatementController;
use App\Http\Controllers\SendEditStatementTwoController;
use App\Http\Controllers\SendEditWordTwoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('contract', function () {
    return view('frontend.pages.contract');
})->name('contract');

Route::get('payment', [PaymentController::class, 'index'])->name('payment');
Route::get('list/research', [ListResearchController::class, 'index'])->name('list.research.index');
Route::get('list/attend', [ListAttendController::class, 'index'])->name('list.attend.index');

// Email Verify
Route::get('email/verify', [MailController::class, 'verify'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [MailController::class, 'verify_id'])->middleware('signed')->name('verification.verify');
Route::post('email/verification-notification', [MailController::class, 'verify_notification'])->middleware('throttle:6,1')->name('verification.send');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('download', [FileDownloadController::class, 'index'])->name('download');

    Route::prefix('employee')->group(function () {
        // ส่งบทความฉบับแก้ไข
        Route::get('research/send', [ResearchController::class, 'index'])->name('employee.research.index');
        Route::get('research/show/{topic_id}', [ResearchController::class, 'show'])->name('employee.research.show');
        Route::post('research/send/create', [ResearchController::class, 'store'])->name('employee.research.store');
        Route::get('research/edit/{topic_id}', [ResearchController::class, 'edit'])->name('employee.research.edit');
        Route::put('research/edit/{topic_id}/update', [ResearchController::class, 'update'])->name('employee.research.update');

        // ส่งบทความฉบับแก้ไข ครั้งที่ 1
        Route::get('research/send-edit/show/{id}', [SendEditResearchController::class, 'show'])->name('employee.research.send.edit');
        Route::post('research/send-edit/word/{id}/create', [SendEditWordController::class, 'store'])->name('employee.research.send.word.store');
        Route::put('research/send-edit/word/{id}/update', [SendEditWordController::class, 'update'])->name('employee.research.send.word.update');
        Route::post('research/send-edit/pdf/{id}/create', [SendEditPdfController::class, 'store'])->name('employee.research.send.pdf.store');
        Route::put('research/send-edit/pdf/{id}/update', [SendEditPdfController::class, 'update'])->name('employee.research.send.pdf.update');
        Route::post('research/send-edit/stm/{id}/create', [SendEditStatementController::class, 'store'])->name('employee.research.send.stm.store');
        Route::put('research/send-edit/stm/{id}/update', [SendEditStatementController::class, 'update'])->name('employee.research.send.stm.update');

        // ส่งบทความฉบับแก้ไข ครั้งที่ 2
        Route::get('research/send-edit-2/show/{id}', [SendEditResearchTwoController::class, 'show'])->name('employee.research.send.two.edit');
        Route::post('research/send-edit/word_2/{id}/create', [SendEditWordTwoController::class, 'store'])->name('employee.research.send.two.word.store');
        Route::put('research/send-edit/word_2/{id}/update', [SendEditWordTwoController::class, 'update'])->name('employee.research.send.two.word.update');
        Route::post('research/send-edit/pdf_2/{id}/create', [SendEditPdfTwoController::class, 'store'])->name('employee.research.send.two.pdf.store');
        Route::put('research/send-edit/pdf_2/{id}/update', [SendEditPdfTwoController::class, 'update'])->name('employee.research.send.two.pdf.update');
        Route::post('research/send-edit/stm_2/{id}/create', [SendEditStatementTwoController::class, 'store'])->name('employee.research.send.two.stm.store');
        Route::put('research/send-edit/stm_2/{id}/update', [SendEditStatementTwoController::class, 'update'])->name('employee.research.send.two.stm.update');


        Route::get('research/video/{id}', [VideoController::class, 'show'])->name('employee.research.video');

        Route::put('payment/{payment_upload}/upload', [PaymentController::class, 'update'])->name('employee.payment.update');
        Route::post('payment/{payment_upload}/create', [PaymentController::class, 'store'])->name('employee.payment.store');

        Route::put('pdf/{pdf_upload}/upload', [PdfController::class, 'update'])->name('employee.pdf.update');
        Route::post('pdf/{pdf_upload}/create', [PdfController::class, 'store'])->name('employee.pdf.store');

        Route::put('word/{word_upload}/upload', [WordController::class, 'update'])->name('employee.word.update');
        Route::post('word/{word_upload}/create', [WordController::class, 'store'])->name('employee.word.store');
    });

    Route::middleware('is_admin')->group(function () {

        Route::prefix('admin')->group(function () {
            Route::prefix('research')->group(function () {
                Route::resource('management', ManageResearchController::class, ['names' => 'admin.research']);
                Route::put('comment-file-upload/{topic_id}', [CommentFileUploadController::class, 'update']);
            });
        });
    });

    Route::middleware('is_super_admin')->group(function () {

        Route::get('storage/open', [DashboardController::class, 'storage'])->name('backend.storage.open');

        Route::prefix('backend')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('backend.dashboard.index');
            Route::get('statement', [StatementController::class, 'index'])->name('backend.statement.index');

            Route::get('researchs', [BackendResearchController::class, 'index'])->name('backend.researchs.index');
            Route::get('research/{topic_id}/edit', [BackendResearchController::class, 'edit'])->name('backend.research.edit');
            Route::put('research/{topic_id}/update', [BackendResearchController::class, 'update'])->name('backend.research.update');

            Route::get('users', [UserController::class, 'index'])->name('backend.users.index');
            Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('backend.user.edit');
            Route::put('user/{id}/update', [UserController::class, 'update'])->name('backend.user.update');

            Route::get('conference', [ConferenceController::class, 'index'])->name('backend.conference.index');
            Route::get('conference/{conference_id}/edit', [ConferenceController::class, 'edit'])->name('backend.conference.edit');
            Route::post('conference/create', [ConferenceController::class, 'store'])->name('backend.conference.store');
            Route::put('conference/{id}/update_status', [ConferenceController::class, 'update_status'])->name('backend.conference.update_status');
            Route::put('conference/{id}/update_topic', [ConferenceController::class, 'update_topic'])->name('backend.conference.update_topic');


            Route::get('download', [DownloadController::class, 'index'])->name('backend.download.index');
        });
    });
});
       

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');