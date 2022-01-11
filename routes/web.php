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

    Route::group([
            'name'      => 'admin.',
            'prefix'    => 'admin',
            'middleware'=> 'is_admin'
        ], function(){
        Route::get('locations/ip', [\App\Http\Controllers\admin\LocationIpsController::class, 'index'])->name('locations_ip_list');
        Route::get('locations/ip/json', [\App\Http\Controllers\admin\LocationIpsController::class, 'list'])->name('locations_ip_list_json');
        Route::post('locations/ip/validate', [\App\Http\Controllers\admin\LocationIpsController::class, 'validateIp'])->name('validate_ip_address');
        Route::post('locations/ip/store', [\App\Http\Controllers\admin\LocationIpsController::class, 'store'])->name('store_ip_address');
        // Route::get('user', [\App\Http\Controllers\admin\PyramidUsersController::class, 'index'])->name('users_list');
        
        Route::get('user/{locationId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'index'])->name('users_list');
        Route::get('user/show/{locationId}/{userId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'show'])->name('user_data');
        Route::post('user/{locationId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'store'])->name('add_user');
        Route::post('users/copy/action', [\App\Http\Controllers\admin\PyramidUsersController::class, 'copyAction'])->name('copy_user');
        Route::put('users/{locationId}/{userId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'updateAction'])->name('update_user');
        
        Route::get('user/access_rules/{locationId}/{userId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'accessRulesShow'])->name('access_rules_list');
        Route::post('user/access_rules/{locationId}/{userId}', [\App\Http\Controllers\admin\PyramidUsersController::class, 'accessRulesStore'])->name('add_user_restrictions');

        Route::get('user/access-rules/templates', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesTemplates'])->name('access_rules_templates');
        Route::get('user/access-rules/template/{TemplateName}', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesTemplate'])->name('access_rules_template');
        Route::post('user/access-rules/new-template', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesTemplateStore'])->name('access_rules_template_store');
        Route::put('user/access-rules/update-template', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesTemplateUpdate'])->name('access_rules_template_update');
        Route::get('user/access-rules/defaults-list', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesDefaults'])->name('access_rules_defaults');
        Route::post('user/access-rules/clone-template', [\App\Http\Controllers\admin\AccessRulesController::class, 'accessRulesTemplateClone'])->name('access_rules_template_clone');
    });
});

