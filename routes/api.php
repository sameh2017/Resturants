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



Route::get('/check_availability', 'App\Http\Controllers\TablesController@checkAvailability');
Route::get('/menu_list', 'App\Http\Controllers\MenuController@index');
Route::post('/reserve_table', 'App\Http\Controllers\ReservationsController@store');
Route::post('/order_table', 'App\Http\Controllers\OrdersController@store');




Route::get('/', function () {
    return 'welcome';
});
