<?php

use App\Http\Controllers\Backend\DownloadController;
use App\Http\Controllers\Backend\ManageResearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Branch;
use App\Http\Controllers\StatusUpdateController;
use App\Http\Controllers\UploadfileController;
use App\Http\Controllers\VideoController;
use App\Models\Conference;
use App\Models\Research;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('auth:sanctum')->group(function(){
//         Route::get('branches', function(Request $request){
//             return Branch::select('name')->where('faculty_id', $request)->get();
//         });
//     });

Route::get('branches', function (Request $request) {
    return Branch::select('id', 'name')->where('faculty_id', $request->faculty_id)->get();
});

Route::get('research/countdown', function () {
    return Conference::select('end_research')
        ->where('conferences.status_research', 1)
        ->first();
    // return Conference::select(
    //     Conference::raw(
    //         "floor(timestampdiff(second, now(), end)/(60*60*24)) as day
    //         ,floor(timestampdiff(second, now(), end)/(60*60)%24) as hour
    //         ,floor(timestampdiff(second, now(), end)/(60)%60) as minute
    //         ,floor(timestampdiff(second, now(), end)%60) as second"
    //     ))
    //     ->where('conferences.status', 1)
    //     ->get();
});

Route::get('conference/open', function () {
    return Conference::where('status', 1)->get();
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('is_admin')->group(function () {
        Route::put('update-status/{id}', [StatusUpdateController::class, 'update']);
        Route::get('show-research-detail/{id}', [ManageResearchController::class, 'show']);

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
                'posters.name as poster_name'
            )
                ->leftjoin('faculties', 'researchs.faculty_id', 'faculties.id')
                ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
                ->leftjoin('posters', 'posters.topic_id', 'researchs.topic_id')
                ->where('researchs.topic_id', $id)
                ->where('conferences.status', 1)
                ->first();
        });
    });
});
