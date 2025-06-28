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

Route::get('', [App\Http\Controllers\Admin\PublicController::class, 'signin']);
Route::get('signin', [App\Http\Controllers\Admin\PublicController::class, 'signin'])->name('signin');
Route::get('logout', [App\Http\Controllers\Admin\PublicController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')
        ->middleware([App\Http\Middleware\AdminAuthenticate::class])
        ->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
            Route::get('dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

            Route::get('users', [App\Http\Controllers\Admin\AdminController::class, 'users_manage'])->name('users.manage');
            Route::get('users/create', [App\Http\Controllers\Admin\AdminController::class, 'users_create'])->name('users.create');
            Route::get('users/delete', [App\Http\Controllers\Admin\AdminController::class, 'users_mange'])->name('users.delete');
            Route::get('users/{key}', [App\Http\Controllers\Admin\AdminController::class, 'users_mange']);
            Route::get('users/{key}/update', [App\Http\Controllers\Admin\AdminController::class, 'users_update']);

            Route::get('leads', [App\Http\Controllers\Admin\AdminController::class, 'leads_manage'])->name('leads.manage');
            Route::get('leads/total', [App\Http\Controllers\Admin\AdminController::class, 'leads_total'])->name('leads.total');
        });

Route::prefix('api/v1')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('signin', [App\Http\Controllers\Admin\RestController::class, 'api_signin']);

        Route::post('users', [App\Http\Controllers\Admin\RestController::class, 'api_users_manage']);
        Route::post('users/create', [App\Http\Controllers\Admin\RestController::class, 'api_users_create']);
        Route::post('users/delete', [App\Http\Controllers\Admin\RestController::class, 'api_users_delete']);
        Route::post('users/{key}', [App\Http\Controllers\Admin\RestController::class, 'api_users_view']);
        Route::post('users/{key}/update', [App\Http\Controllers\Admin\RestController::class, 'api_users_update']);

        Route::post('leads', [App\Http\Controllers\Admin\RestController::class, 'api_leads_manage']);
        Route::post('leads/create', [App\Http\Controllers\Admin\RestController::class, 'api_leads_create']);
        Route::post('leads/delete', [App\Http\Controllers\Admin\RestController::class, 'api_leads_delete']);
        Route::post('leads/{key}', [App\Http\Controllers\Admin\RestController::class, 'api_leads_view']);
        Route::post('leads/{key}/update', [App\Http\Controllers\Admin\RestController::class, 'api_leads_update']);
    });
});

