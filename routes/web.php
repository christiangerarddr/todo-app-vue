<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use  App\Http\Controllers\TodoController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/todos',       [TodoController::class, 'index']);
    Route::prefix('/todo')->middleware('auth')->group(function(){
        Route::post('/withFinished',  [TodoController::class, 'toggleWithTrashed']);
        Route::post('/store',  [TodoController::class, 'store']);
        Route::put('/{id}' ,   [TodoController::class, 'update']);
        Route::delete('/{id}/{permanent}', [TodoController::class, 'destroy'] );
        Route::post('/restore/{id}', [TodoController::class, 'restore'] );
    });
});

require __DIR__.'/auth.php';
