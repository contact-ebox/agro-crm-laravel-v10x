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
    return redirect("/admin");
});

Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('home');
            Route::get('dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        });

Route::prefix('api/v1')->group(function () {
    Route::prefix('admin')->group(function () {
        
    });
});

