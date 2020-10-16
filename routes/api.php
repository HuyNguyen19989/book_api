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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('login', function(){
    return view('form');
});

Route::post('login', 'App\Http\Controllers\api\UserController@login');
Route::post('register', 'App\Http\Controllers\api\UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('details', 'App\Http\Controllers\api\UserController@details');
    Route::post('logout', 'App\Http\Controllers\api\UserController@logout');
});

// Api sach
Route::get('books', 'App\Http\Controllers\api\ApiController@bookindex');
Route::get('books/{id}', 'App\Http\Controllers\api\ApiController@bookinfo')->where('id', '[0-9]+');
Route::group(['middleware' => 'auth:api'], function() {
Route::post('bookcreate', 'App\Http\Controllers\api\ApiController@bookcreate');
Route::post('cover', 'App\Http\Controllers\api\ApiController@cover');
});