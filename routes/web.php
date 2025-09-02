<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('dashboard');
    return view('mesadecontrol');
})->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // return view('dashboard');
        return view('mesadecontrol');
    })->name('dashboard');

    Route::get('/mesadecontrol', function () {
        return view('mesadecontrol');
    })->name('mesadecontrol');

    Route::get('/estadisticas', function () {
        return view('estadisticas');
    })->name('estadisticas');
});
