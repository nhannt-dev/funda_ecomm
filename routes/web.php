<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'Index'])->name('dashboard');

    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
        Route::get('category', 'Index')->name('category');
        Route::get('category/create', 'Create')->name('createcategory');
        Route::post('category', 'Store')->name('storecategory');
        Route::get('category/edit/{category}', 'Edit')->name('editcategory');
        Route::put('category/update/{category}', 'Update')->name('updatecategory');
    });
    
    Route::get('brands', App\Http\Livewire\Admin\Brand\Index::class)->name('brands');
    
    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('products', 'Index')->name('product');
        Route::get('product/create', 'Create')->name('createproduct');
        Route::post('products', 'Store')->name('storeproduct');
        Route::get('product/edit/{id}', 'Edit')->name('editproduct');
        Route::put('product/update/{id}', 'Update')->name('updateproduct');
        Route::get('product/remove/{id}', 'RemoveImg')->name('removeimage');
        Route::get('product/delete/{id}', 'Delete')->name('deleteproduct');
    });
});
