<?php

use Illuminate\Http\Request;

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

Route::apiResource('countries', 'CountryController')
    ->only('index');

Route::apiResource('states', 'StateController')
    ->only('index');

Route::apiResource('cities', 'CityController')
    ->only('index');

Route::apiResource('properties', 'PropertyController')
    ->only('store', 'index', 'destroy');
