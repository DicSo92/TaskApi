<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('api.login');
Route::post('/register', [\App\Http\Controllers\UserController::class, 'register'])->name('api.register');

Route::prefix('tasks')->name('tasks.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])->name('index');
    Route::get('/{taskId}', [\App\Http\Controllers\TaskController::class, 'show'])->name('show');
    Route::post('/create', [\App\Http\Controllers\TaskController::class, 'store'])->name('create');
    Route::put('/update/{taskId}', [\App\Http\Controllers\TaskController::class, 'update'])->name('update');
    Route::delete('/destroy/{taskId}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('destroy');
});
