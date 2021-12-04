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

Route::get('/', 'App\Http\Controllers\AuthController@index');
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api', 'verified'])->group(function () {

    Route::post('logout', 'App\Http\Controllers\AuthController@logout');

    Route::middleware(['rider'])->group(function () {
        Route::get('buses/available', 'App\Http\Controllers\BookingController@index');
        Route::post('book/ride', 'App\Http\Controllers\BookingController@book');
        Route::get('bookings', 'App\Http\Controllers\BookingController@myBookings');
    });

    Route::middleware(['driver'])->group(function () {
        Route::get('bookings/accepted', 'App\Http\Controllers\DriverController@index');
        Route::get('booking/{booking}/show', 'App\Http\Controllers\DriverController@show');
        Route::get('trip/{trip}/show', 'App\Http\Controllers\DriverController@showTrip');
        Route::post('booking/{booking}/action', 'App\Http\Controllers\DriverController@action');
        Route::get('bookings/pending', 'App\Http\Controllers\DriverController@pending');
        Route::post('trip/{trip}/complete', 'App\Http\Controllers\DriverController@markTripCompleted');
        Route::get('trips', 'App\Http\Controllers\DriverController@allTrips');

        Route::get('buses', 'App\Http\Controllers\BusController@myBuses');
        Route::post('bus/create', 'App\Http\Controllers\BusController@store');
        Route::get('bus/{bus}/show', 'App\Http\Controllers\BusController@show');
        Route::post('bus/{bus}/update', 'App\Http\Controllers\BusController@update');
        Route::delete('bus/{bus}/delete', 'App\Http\Controllers\BusController@destroy');
    });

});
