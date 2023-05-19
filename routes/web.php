<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QnAController;
use App\Http\Livewire\QnATable;
use App\Models\Resume;

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

/**
 * Landing page
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth middleware
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    /**
     * Dashboard
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /**
     * Resumify
     */
    Route::get('/resumify', function () {
        return view('resumify');
    })->name('resumify');

    Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');


    /**
     * Q&A view
     */
    Route::get('/Q&A', function () {
        $inputText = session('input_text');
        return view('q&a', compact('inputText'));
    })->name('Q&A');

    Route::post('/Q&A', [QnAController::class, 'store'])->name('QnA.store');

});
