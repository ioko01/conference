<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Branch;
use App\Http\Controllers\StatusUpdateController;

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

Route::get('branches', function(Request $request){
    return Branch::select('id', 'name')->where('faculty_id', $request->faculty_id)->get();
});

Route::middleware(['auth', 'verified', 'is_admin'])->group(function(){
    Route::put('update-status/{id}', [StatusUpdateController::class, 'update']);
});
