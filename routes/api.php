<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource("employees", EmployeeController::class);
Route::resource('clients', ClientController::class);
Route::resource('channels', ChannelController::class);
Route::get('clients/list', [ClientController::class, 'clients']);

