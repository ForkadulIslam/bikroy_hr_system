<?php

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


use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobsController;

Route::get('/', [AuthController::class, 'index']);
Route::get('admin', [Admin::class, 'index']);
Route::post('/login',[AuthController::class, 'login']);
Route::get('/logout',[AuthController::class, 'logout']);


Route::group(['prefix'=>'module'],function(){
    Route::resource('banner', JobsController::class);
    Route::get('scrap_data_for_deals_ad',[JobsController::class, 'scrap_data']);
    Route::get('deals_preview',[JobsController::class,'deals_preview']);
    Route::get('delete_banner_content/{id}',[JobsController::class, 'delete_banner_content']);
    Route::get('clean_broken_ad',[JobsController::class, 'clean_broken_ad']);
});
Route::get('create_html_file/{id}',[JobsController::class,'create_html_file']);
