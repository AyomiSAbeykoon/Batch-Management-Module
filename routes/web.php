<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BatchController;
;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('students', StudentController::class);
    Route::get('/students/audit_log/{id}', [StudentController::class, 'audit_log']);
    Route::resource('batches', BatchController::class);
    Route::get('/batches/audit_log/{id}', [BatchController::class, 'audit_log']);
    Route::post('/extend-date', [App\Http\Controllers\BatchController::class, 'extendDate']);

});
