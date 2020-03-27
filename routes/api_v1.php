<?php

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

Route::post('authentication', 'Auth\AuthenticationController@authentication')->middleware('guest');

Route::post('auth/register', 'Auth\RegisterController@register')->middleware('guest');
Route::post('auth/login', 'Auth\LoginController@login')->middleware('guest');

Route::get('chats', 'Chat\ChatController@index')->middleware('auth:api');

Route::get('chats/{chat}/messages', 'Chat\MessageController@index')->middleware('auth:api');
Route::post('chats/{chat}/messages', 'Chat\MessageController@store')->middleware('auth:api');
