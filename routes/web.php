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
    Route::get('product-tumb/{id}/{table}', [App\Http\Controllers\ImagesController::class, 'productImageTumb'])->name('get_product_tumb');
    Route::get('product-image/{id}', [App\Http\Controllers\ImagesController::class, 'productImage'])->name('get_product');

    Route::group([
            'name'      => 'admin.',
            'prefix'    => 'admin',
            'middleware'=> 'is_admin'
        ], function(){

            Route::get('/products', [App\Http\Controllers\admin\ProductsController::class, 'index'])->name('products_list');
            Route::get('/products/create', [App\Http\Controllers\admin\ProductsController::class, 'create'])->name('add_product_form');
            Route::post('/products/store', [App\Http\Controllers\admin\ProductsController::class, 'store'])->name('store_product');

            Route::get('/products/{id}', [App\Http\Controllers\admin\ProductsController::class, 'edit'])->name('edit_product');
            Route::get('/products/{id}/send-to-dispenser-form', [App\Http\Controllers\admin\ProductsController::class, 'showSendToDispenser'])->name('product_to_dispenser');
            Route::get('/products/{id}/send-to-locker-form', [App\Http\Controllers\admin\ProductsController::class, 'showSendToLocker'])->name('product_to_locker');

            Route::post('products/send-to-dispenser', [App\Http\Controllers\admin\ProductsController::class, 'sendToDispenser'])->name('send_product_to_dispenser');
            Route::post('products/send-to-locker', [App\Http\Controllers\admin\ProductsController::class, 'sendToLocker'])->name('send_product_to_locker');


            Route::get('/wine-dispenser', [App\Http\Controllers\WineDispenserController::class, 'index'])->name('wine_dispenser');
            Route::get('/wine-dispenser/{slotId}', [App\Http\Controllers\WineDispenserController::class, 'edit'])->name('wine_slot_edit');
            Route::get('/wine-dispenser/{slotId}/change-product', [App\Http\Controllers\WineDispenserController::class, 'changeProduct'])->name('wine_change_product');
            Route::post('/wine-dispenser/{slotId}/push-product', [App\Http\Controllers\WineDispenserController::class, 'pushProduct'])->name('wine_push_product');

            Route::get('/smart-locker', [App\Http\Controllers\SmartLockerController::class, 'index'])->name('smart_locker');
            Route::get('/smart-locker/{slotId}', [App\Http\Controllers\SmartLockerController::class, 'edit'])->name('locker_slot_edit');
            Route::post('/smart-locker/{slotId}/update-slot', [App\Http\Controllers\SmartLockerController::class, 'updateSlot'])->name('locker_update_slot');
            Route::get('/smart-locker/{slotId}/change-product', [App\Http\Controllers\SmartLockerController::class, 'changeProduct'])->name('locker_change_product');
            Route::post('/smart-locker/{slotId}/push-product', [App\Http\Controllers\SmartLockerController::class, 'pushProduct'])->name('locker_push_product');

            Route::get('/users', [App\Http\Controllers\admin\UsersController::class, 'index'])->name('users_list');
            Route::get('/users/create', [App\Http\Controllers\admin\UsersController::class, 'create'])->name('create_user');
            Route::post('/users', [App\Http\Controllers\admin\UsersController::class, 'store'])->name('store_user');
            Route::get('/users/{id}', [App\Http\Controllers\admin\UsersController::class, 'edit'])->name('edit_user');
            Route::patch('/users/{id}', [App\Http\Controllers\admin\UsersController::class, 'update'])->name('update_user');

            Route::get('/settings', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('settings');
    });

    Route::group([
            'name'      => 'user',
            'prefix'    => 'user',
            'middleware'=> 'is_user'
        ], function(){

    });
});

