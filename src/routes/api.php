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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::pattern('apiVersion1', 'v1');

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => '{apiVersion1}'], function () {
    Route::get('/sample', 'SampleController@get');
});