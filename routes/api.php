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



Route::group([
    "middleware" => "auth.student"
],function(){
    Route::post('students','StudentController@create');
    Route::get('students/{search_string}','StudentController@getStudentsBySearchString');
});

