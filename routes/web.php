<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'dashboard');

Auth::routes();

Route::group(['middleware' => 'auth'], function (){
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients');
    Route::get('/clients/add', [\App\Http\Controllers\ClientController::class, 'create'])->name('create_client');
    Route::post('/clients/add', [\App\Http\Controllers\ClientController::class, 'store'])->name('store_client');
    Route::get('/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('materials');
    Route::get('/materials/add', [\App\Http\Controllers\MaterialController::class, 'create'])->name('create_material');
    Route::post('/materials/add', [\App\Http\Controllers\MaterialController::class, 'store'])->name('store_material');
    Route::get('access-rules', [\App\Http\Controllers\AccessRulesController::class, 'index'])->name('access_rules');
    Route::post('access-rules/{user_id}', [\App\Http\Controllers\AccessRulesController::class, 'index'])->name('rst_user_token');

    Route::post('user/reset_api_token', [\App\Http\Controllers\AccessRulesController::class, 'tokenReset'])->name('reset_api_token');
    //Route::get('/static-repair', [\App\Http\Controllers\StaticRepairsController::index])->name('static-repair');
});

