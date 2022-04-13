<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Branch;
use App\Http\Controllers\StatusUpdateController;
use App\Http\Controllers\ManageResearchController;
use App\Models\Conference;

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

Route::get('research/timeleft', function () {
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

Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    Route::put('update-status/{id}', [StatusUpdateController::class, 'update']);
    Route::get('show-research-detail/{id}', [ManageResearchController::class, 'show']);
});
