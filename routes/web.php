<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ResearchController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\Backend\CommentFileUploadController;
use App\Http\Controllers\Backend\ConferenceController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DownloadController;
use App\Http\Controllers\Backend\EditResearchFirstController;
use App\Http\Controllers\Backend\EditResearchSecondController;
use App\Http\Controllers\Backend\LineController;
use App\Http\Controllers\Backend\ManageResearchController;
use App\Http\Controllers\Backend\NoticeController;
use App\Http\Controllers\Backend\PosterController as BackendPosterController;
use App\Http\Controllers\Backend\ResearchController as BackendResearchController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ListAttendController;
use App\Http\Controllers\ListResearchController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\SendEditResearchController;
use App\Http\Controllers\SendEditWordController;
use App\Http\Controllers\SendEditPdfController;
use App\Http\Controllers\SendEditPdfTwoController;
use App\Http\Controllers\SendEditResearchTwoController;
use App\Http\Controllers\SendEditStatementController;
use App\Http\Controllers\SendEditStatementTwoController;
use App\Http\Controllers\SendEditWordTwoController;
use App\Http\Controllers\UploadfileController;
use App\Models\Download;
use App\Models\Line;
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
    $downloads = Download::select(
        'downloads.notice as notice',
        'downloads.name as name',
        'downloads.link as link',
        'downloads.name_file as name_file',
        'downloads.path_file as path_file',
        'downloads.ext_file as ext_file',
        'downloads.created_at as created_at',
    )
        ->leftjoin('conferences', 'conferences.id', 'downloads.conference_id')
        ->where('conferences.status', 1)
        ->where('notice', 1)
        ->orderBy('created_at', 'desc')->get();
    $lines = Line::select(
        'lines.id as id',
        'conferences.name as conference_name',
        'lines.link as line_link',
        'lines.name as line_name',
        'lines.path as line_path',
        'lines.extension as line_extension'
    )
        ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
        ->where('conferences.status', 1)
        ->get();
    return view('welcome', compact('downloads', 'lines'));
})->name('welcome');

Route::get('contract', function () {
    return view('frontend.pages.contract');
})->name('contract');

Route::get('payment', [PaymentController::class, 'index'])->name('payment');
Route::get('list/research', [ListResearchController::class, 'index'])->name('list.research.index');
Route::get('list/attend', [ListAttendController::class, 'index'])->name('list.attend.index');

Route::get('posters', [PosterController::class, 'index'])->name('posters.index');

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


        Route::get('research/uploadfile/{id}', [UploadfileController::class, 'show'])->name('employee.research.uploadfile');
        Route::post('research/uploadfile/{id}/create', [UploadfileController::class, 'store'])->name('employee.research.uploadfile.store');
        Route::put('research/uploadfile/{id}/update', [UploadfileController::class, 'update'])->name('employee.research.uploadfile.update');

        Route::put('payment/{payment_upload}/upload', [PaymentController::class, 'update'])->name('employee.payment.update');
        Route::post('payment/{payment_upload}/create', [PaymentController::class, 'store'])->name('employee.payment.store');

        Route::put('pdf/{pdf_upload}/upload', [PdfController::class, 'update'])->name('employee.pdf.update');
        Route::post('pdf/{pdf_upload}/create', [PdfController::class, 'store'])->name('employee.pdf.store');

        Route::put('word/{word_upload}/upload', [WordController::class, 'update'])->name('employee.word.update');
        Route::post('word/{word_upload}/create', [WordController::class, 'store'])->name('employee.word.store');
    });

    Route::middleware('is_admin')->group(function () {

        Route::prefix('backend')->group(function () {
            Route::prefix('researchs')->group(function () {
                Route::get('management', [ManageResearchController::class, 'index'])->name('backend.research.index');
                Route::get('management/times/1', [EditResearchFirstController::class, 'index'])->name('backend.research.first.index');
                Route::get('management/times/2', [EditResearchSecondController::class, 'index'])->name('backend.research.second.index');
                Route::put('comment-file-upload/{topic_id}', [CommentFileUploadController::class, 'update']);
                Route::get('export', [BackendResearchController::class, 'export'])->name('researchs.export');
            });

            Route::get('dashboard', [DashboardController::class, 'index'])->name('backend.dashboard.index');

            Route::get('researchs', [BackendResearchController::class, 'index'])->name('backend.researchs.index');
            Route::get('research/{topic_id}/edit', [BackendResearchController::class, 'edit'])->name('backend.research.edit');
            Route::put('research/{topic_id}/update', [BackendResearchController::class, 'update'])->name('backend.research.update');

            Route::get('posters', [BackendPosterController::class, 'index'])->name('backend.posters.index');

            Route::prefix('users')->group(function () {
                Route::get('export', [UserController::class, 'export'])->name('users.export');
            });
        });
    });

    Route::middleware('is_super_admin')->group(function () {

        Route::get('storage/open', [DashboardController::class, 'storage'])->name('backend.storage.open');

        Route::prefix('backend')->group(function () {
            Route::get('users', [UserController::class, 'index'])->name('backend.users.index');
            Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('backend.user.edit');
            Route::put('user/{id}/update', [UserController::class, 'update'])->name('backend.user.update');

            Route::get('conference', [ConferenceController::class, 'index'])->name('backend.conference.index');
            Route::get('conference/{conference_id}/edit', [ConferenceController::class, 'edit'])->name('backend.conference.edit');
            Route::post('conference/create', [ConferenceController::class, 'store'])->name('backend.conference.store');
            Route::put('conference/{id}/update_status', [ConferenceController::class, 'update_status'])->name('backend.conference.update_status');
            Route::put('conference/{id}/update_topic', [ConferenceController::class, 'update_topic'])->name('backend.conference.update_topic');

            Route::get('downloads', [DownloadController::class, 'index'])->name('backend.downloads.index');
            Route::post('download/create', [DownloadController::class, 'store'])->name('backend.download.store');
            Route::get('download/{id}/edit', [DownloadController::class, 'edit'])->name('backend.download.edit');
            Route::put('download/{id}/update', [DownloadController::class, 'update'])->name('backend.download.update');
            Route::delete('download/{id}/delete', [DownloadController::class, 'destroy'])->name('backend.download.delete');
            Route::put('download/notice/{id}/update', [DownloadController::class, 'notice'])->name('backend.download.notice.update');

            Route::get('lines', [LineController::class, 'index'])->name('backend.lines.index');
            Route::post('line/create', [LineController::class, 'store'])->name('backend.line.store');
            Route::get('line/{id}/edit', [LineController::class, 'edit'])->name('backend.line.edit');
            Route::put('line/{id}/update', [LineController::class, 'update'])->name('backend.line.update');
            Route::delete('line/{id}/delete', [LineController::class, 'destroy'])->name('backend.line.delete');
        });
    });
});
       

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');