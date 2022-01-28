<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\FileUploadController;
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

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::prefix('employee')->group(function(){
        Route::resource('research', ResearchController::class, ['names' => 'employee.research']);
        Route::resource('file-upload', FileUploadController::class, ['names' => 'employee.file-upload']);
    });
});
        
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');