<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::withoutMiddleware("web")->post('api/v1/easy_money', [App\Http\Controllers\EasyMoneyController::class, 'pay']);
Route::withoutMiddleware("web")->post('api/v1/super_walletz', [App\Http\Controllers\SuperWalletzController::class, 'pay']);
Route::withoutMiddleware("web")->post('api/v1/super_walletz/callback', [App\Http\Controllers\SuperWalletzController::class, 'callback']);
