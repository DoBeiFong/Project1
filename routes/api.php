<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/signup/","UserController@signUp");
Route::post("/signin/","UserController@signIn");
Route::post("/signin/","UserController@exit");
Route::post("/signin/","UserController@reset_password");
