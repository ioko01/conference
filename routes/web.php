<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\ResearchController as ApiResearchController;
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
use App\Http\Controllers\Backend\LinkOralController as BackendLinkOralController;
use App\Http\Controllers\Backend\ManageResearchController;
use App\Http\Controllers\Backend\ManualController;
use App\Http\Controllers\Backend\PresentOralController;
use App\Http\Controllers\Backend\PresentPosterController;
use App\Http\Controllers\Backend\ProceedingFileController;
use App\Http\Controllers\Backend\ProceedingPreviewController;
use App\Http\Controllers\Backend\ProceedingResearchController;
use App\Http\Controllers\Backend\ProceedingTopicController;
use App\Http\Controllers\Backend\ResearchController as BackendResearchController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\LinkOralController;
use App\Http\Controllers\ListAttendController;
use App\Http\Controllers\ListResearchController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OralController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\ProceedingController;
use App\Http\Controllers\SendEditResearchController;
use App\Http\Controllers\SendEditWordController;
use App\Http\Controllers\SendEditPdfController;
use App\Http\Controllers\SendEditPdfTwoController;
use App\Http\Controllers\SendEditResearchTwoController;
use App\Http\Controllers\SendEditStatementController;
use App\Http\Controllers\SendEditStatementTwoController;
use App\Http\Controllers\SendEditWordTwoController;
use App\Http\Controllers\StatusUpdateController;
use App\Http\Controllers\UploadfileController;
use App\Models\Conference;
use App\Models\Download;
use App\Models\Line;
use App\Models\Research;
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
Route::get('orals', [OralController::class, 'index'])->name('orals.index');
Route::get('orals/link', [LinkOralController::class, 'index'])->name('orals.link.index');

Route::get('proceeding/{year}', [ProceedingController::class, 'index'])->name('proceeding.index');

// Email Verify
Route::get('email/verify', [MailController::class, 'verify'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [MailController::class, 'verify_id'])->middleware('signed')->name('verification.verify');
Route::post('email/verification-notification', [MailController::class, 'verify_notification'])->middleware('throttle:6,1')->name('verification.send');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('show-research-detail/{id}', [ApiResearchController::class, 'show']);

    Route::get('download', [FileDownloadController::class, 'index'])->name('download');

    Route::prefix('employee')->group(function () {
        Route::get('account', [AccountController::class, 'index'])->name('account.index');
        Route::get('change-password', [PasswordController::class, 'change_password'])->name('user.change_password');
        Route::put('update-password', [PasswordController::class, 'update_password'])->name('user.update_password');

        // ส่งบทความฉบับแก้ไข
        Route::get('research/send', [ResearchController::class, 'index'])->name('employee.research.index');
        Route::get('research/show/{topic_id}', [ResearchController::class, 'show'])->name('employee.research.show');
        Route::post('research/send/store', [ResearchController::class, 'store'])->name('employee.research.store');
        Route::get('research/edit/{topic_id}', [ResearchController::class, 'edit'])->name('employee.research.edit');
        Route::put('research/edit/{topic_id}/update', [ResearchController::class, 'update'])->name('employee.research.update');

        // ส่งบทความฉบับแก้ไข ครั้งที่ 1
        Route::get('research/send-edit/show/{id}', [SendEditResearchController::class, 'show'])->name('employee.research.send.edit');
        Route::post('research/send-edit/word/{id}/store', [SendEditWordController::class, 'store'])->name('employee.research.send.word.store');
        Route::put('research/send-edit/word/{id}/update', [SendEditWordController::class, 'update'])->name('employee.research.send.word.update');
        Route::post('research/send-edit/pdf/{id}/store', [SendEditPdfController::class, 'store'])->name('employee.research.send.pdf.store');
        Route::put('research/send-edit/pdf/{id}/update', [SendEditPdfController::class, 'update'])->name('employee.research.send.pdf.update');
        Route::post('research/send-edit/stm/{id}/store', [SendEditStatementController::class, 'store'])->name('employee.research.send.stm.store');
        Route::put('research/send-edit/stm/{id}/update', [SendEditStatementController::class, 'update'])->name('employee.research.send.stm.update');

        // ส่งบทความฉบับแก้ไข ครั้งที่ 2
        Route::get('research/send-edit-2/show/{id}', [SendEditResearchTwoController::class, 'show'])->name('employee.research.send.two.edit');
        Route::post('research/send-edit/word_2/{id}/store', [SendEditWordTwoController::class, 'store'])->name('employee.research.send.two.word.store');
        Route::put('research/send-edit/word_2/{id}/update', [SendEditWordTwoController::class, 'update'])->name('employee.research.send.two.word.update');
        Route::post('research/send-edit/pdf_2/{id}/store', [SendEditPdfTwoController::class, 'store'])->name('employee.research.send.two.pdf.store');
        Route::put('research/send-edit/pdf_2/{id}/update', [SendEditPdfTwoController::class, 'update'])->name('employee.research.send.two.pdf.update');
        Route::post('research/send-edit/stm_2/{id}/store', [SendEditStatementTwoController::class, 'store'])->name('employee.research.send.two.stm.store');
        Route::put('research/send-edit/stm_2/{id}/update', [SendEditStatementTwoController::class, 'update'])->name('employee.research.send.two.stm.update');


        Route::get('research/uploadfile/{id}', [UploadfileController::class, 'show'])->name('employee.research.uploadfile');
        Route::post('research/uploadfile/{id}/store', [UploadfileController::class, 'store'])->name('employee.research.uploadfile.store');
        Route::put('research/uploadfile/{id}/update', [UploadfileController::class, 'update'])->name('employee.research.uploadfile.update');

        Route::put('payment/{payment_upload}/upload', [PaymentController::class, 'update'])->name('employee.payment.update');
        Route::post('payment/{payment_upload}/store', [PaymentController::class, 'store'])->name('employee.payment.store');

        Route::put('pdf/{pdf_upload}/upload', [PdfController::class, 'update'])->name('employee.pdf.update');
        Route::post('pdf/{pdf_upload}/store', [PdfController::class, 'store'])->name('employee.pdf.store');

        Route::put('word/{word_upload}/upload', [WordController::class, 'update'])->name('employee.word.update');
        Route::post('word/{word_upload}/store', [WordController::class, 'store'])->name('employee.word.store');
    });

    Route::middleware('is_admin')->group(function () {

        Route::get('conference/open', function () {
            return Conference::where('status', 1)->get();
        });

        Route::put('update-status/{id}', [StatusUpdateController::class, 'update']);

        Route::get('get-research/{id}', function ($id) {
            return Research::select(
                'researchs.conference_id as conference_id',
                'researchs.user_id as user_id',
                'researchs.topic_id as topic_id',
                'researchs.topic_th as topic_th',
                'researchs.topic_en as topic_en',
                'researchs.topic_status as topic_status',
                'researchs.presenter as presenter',
                'faculties.id as faculty_id',
                'posters.name as poster_name',
                'videos.link as video_link'
            )
                ->leftjoin('faculties', 'researchs.faculty_id', 'faculties.id')
                ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
                ->leftjoin('posters', 'posters.topic_id', 'researchs.topic_id')
                ->leftjoin('videos', 'videos.topic_id', 'researchs.topic_id')
                ->where('researchs.topic_id', $id)
                ->where('conferences.status', 1)
                ->first();
        });

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

            Route::get('posters', [PresentPosterController::class, 'index'])->name('backend.posters.index');
            Route::post('poster/store', [PresentPosterController::class, 'store'])->name('backend.poster.store');
            Route::get('poster/{topic_id}/edit', [PresentPosterController::class, 'edit'])->name('backend.poster.edit');
            Route::put('poster/{topic_id}/update', [PresentPosterController::class, 'update'])->name('backend.poster.update');
            Route::delete('poster/{id}/delete', [PresentPosterController::class, 'destroy'])->name('backend.poster.delete');

            Route::get('orals', [PresentOralController::class, 'index'])->name('backend.orals.index');
            Route::post('oral/store', [PresentOralController::class, 'store'])->name('backend.oral.store');
            Route::get('oral/{topic_id}/edit', [PresentOralController::class, 'edit'])->name('backend.oral.edit');
            Route::put('oral/{topic_id}/update', [PresentOralController::class, 'update'])->name('backend.oral.update');
            Route::delete('oral/{id}/delete', [PresentOralController::class, 'destroy'])->name('backend.oral.delete');

            Route::get('orals/link', [BackendLinkOralController::class, 'index'])->name('backend.orals.link.index');
            Route::post('orals/link/store', [BackendLinkOralController::class, 'store'])->name('backend.oral.link.store');
            Route::get('orals/link/{id}/edit', [BackendLinkOralController::class, 'edit'])->name('backend.oral.link.edit');
            Route::put('orals/link/{id}/update', [BackendLinkOralController::class, 'update'])->name('backend.oral.link.update');
            Route::delete('orals/link/{id}/delete', [BackendLinkOralController::class, 'destroy'])->name('backend.oral.link.delete');

            Route::get('proceeding/{year}/topic', [ProceedingTopicController::class, 'index'])->name('backend.proceeding.topic.index');
            Route::post('proceeding/{year}/topic/store', [ProceedingTopicController::class, 'store'])->name('backend.proceeding.topic.store');
            Route::get('proceeding/{year}/topic/{id}/edit', [ProceedingTopicController::class, 'edit'])->name('backend.proceeding.topic.edit');
            Route::put('proceeding/{year}/topic/{id}/update', [ProceedingTopicController::class, 'update'])->name('backend.proceeding.topic.update');
            Route::delete('proceeding/{year}/topic/{id}/delete', [ProceedingTopicController::class, 'destroy'])->name('backend.proceeding.topic.delete');

            Route::get('proceeding/{year}/research', [ProceedingResearchController::class, 'index'])->name('backend.proceeding.research.index');
            Route::post('proceeding/{year}/research/store', [ProceedingResearchController::class, 'store'])->name('backend.proceeding.research.store');
            Route::get('proceeding/{year}/research/{id}/edit', [ProceedingResearchController::class, 'edit'])->name('backend.proceeding.research.edit');
            Route::put('proceeding/{year}/research/{id}/update', [ProceedingResearchController::class, 'update'])->name('backend.proceeding.research.update');
            Route::delete('proceeding/{year}/research/{id}/delete', [ProceedingResearchController::class, 'destroy'])->name('backend.proceeding.research.delete');

            Route::get('proceeding/{year}/file', [ProceedingFileController::class, 'index'])->name('backend.proceeding.file.index');
            Route::post('proceeding/{year}/file/store', [ProceedingFileController::class, 'store'])->name('backend.proceeding.file.store');
            Route::get('proceeding/{year}/file/{id}/edit', [ProceedingFileController::class, 'edit'])->name('backend.proceeding.file.edit');
            Route::put('proceeding/{year}/file/{id}/update', [ProceedingFileController::class, 'update'])->name('backend.proceeding.file.update');
            Route::delete('proceeding/{year}/file/{id}/delete', [ProceedingFileController::class, 'destroy'])->name('backend.proceeding.file.delete');

            Route::get('proceeding/{year}/preview', [ProceedingPreviewController::class, 'index'])->name('backend.proceeding.preview.index');

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

            Route::get('user/{id}/change-password', [UserController::class, 'change_password'])->name('backend.user.change_password');
            Route::put('user/{id}/update-password', [UserController::class, 'update_password'])->name('backend.user.update_password');

            Route::get('conference', [ConferenceController::class, 'index'])->name('backend.conference.index');
            Route::get('conference/{conference_id}/edit', [ConferenceController::class, 'edit'])->name('backend.conference.edit');
            Route::post('conference/store', [ConferenceController::class, 'store'])->name('backend.conference.store');
            Route::put('conference/{id}/update_status', [ConferenceController::class, 'update_status'])->name('backend.conference.update_status');
            Route::put('conference/{id}/update_topic', [ConferenceController::class, 'update_topic'])->name('backend.conference.update_topic');

            Route::get('manuals', [ManualController::class, 'index'])->name('backend.manuals.index');
            Route::post('manual/store', [ManualController::class, 'store'])->name('backend.manual.store');
            Route::get('manual/{id}/edit', [ManualController::class, 'edit'])->name('backend.manual.edit');
            Route::put('manual/{id}/update', [ManualController::class, 'update'])->name('backend.manual.update');
            Route::delete('manual/{id}/delete', [ManualController::class, 'destroy'])->name('backend.manual.delete');
            Route::put('manual/notice/{id}/update', [ManualController::class, 'notice'])->name('backend.manual.notice.update');

            Route::get('downloads', [DownloadController::class, 'index'])->name('backend.downloads.index');
            Route::post('download/store', [DownloadController::class, 'store'])->name('backend.download.store');
            Route::get('download/{id}/edit', [DownloadController::class, 'edit'])->name('backend.download.edit');
            Route::put('download/{id}/update', [DownloadController::class, 'update'])->name('backend.download.update');
            Route::delete('download/{id}/delete', [DownloadController::class, 'destroy'])->name('backend.download.delete');
            Route::put('download/notice/{id}/update', [DownloadController::class, 'notice'])->name('backend.download.notice.update');

            Route::get('lines', [LineController::class, 'index'])->name('backend.lines.index');
            Route::post('line/store', [LineController::class, 'store'])->name('backend.line.store');
            Route::get('line/{id}/edit', [LineController::class, 'edit'])->name('backend.line.edit');
            Route::put('line/{id}/update', [LineController::class, 'update'])->name('backend.line.update');
            Route::delete('line/{id}/delete', [LineController::class, 'destroy'])->name('backend.line.delete');
        });
    });
});
       

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');