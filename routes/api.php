<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\Auth\AdminController;

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

Route::prefix('auth/admin')->controller(AdminController::class)->group(function(){
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::get('/user-profile', 'userProfile');
});


/* Route::post('/admin/upload', [ProviderController::class, 'store']);
Route::get('/admin/usersData', [ProviderController::class, 'getUsersData']);
Route::get('/admin/filterByItem', [ProviderController::class, 'singleValueFilter']);
Route::get('/admin/rangeFilter', [ProviderController::class, 'rangeFilter']); */

Route::prefix('admin')->controller(ProviderController::class)->group(function(){
    Route::get('/upload', 'store');
    Route::get('/usersData', 'getUsersData');
    Route::get('/filterByItem', 'filterByItem');
    Route::get('/filterByRange', 'filterByRange');
});

