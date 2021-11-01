<?php

use Illuminate\Http\Request;
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

Route::post('/v2/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::group([
        'name'      => 'v2.',
        'prefix'    => 'v2',
        'middleware'=> 'auth:sanctum'
    ], function(){
        //Route::get('/ob-actions', [\App\Http\Controllers\OBAActionController::class, 'index'])->name('ob_actions');
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});
