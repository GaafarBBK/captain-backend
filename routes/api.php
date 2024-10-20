<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptainSubscribersController;
use App\Http\Controllers\CaptainSubscriptionsController;

Route::post("register",[UserController::class,"store"]);
Route::post("login",[UserController::class,"login"]);


Route::middleware(['auth:api'])->group(function () {

    Route::put("user/update",[UserController::class,"update"]);
    Route::get("user/info",[UserController::class,"getUser"]);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('refresh', [UserController::class, 'refresh']);

    Route::post("sub/create",[CaptainSubscriptionsController::class,"store"]);
    Route::post("sub/show",[CaptainSubscriptionsController::class,"show"]);
    Route::post("sub/update",[CaptainSubscriptionsController::class,"update"]);


    Route::post("buy",[CaptainSubscribersController::class,"buySubscription"]);

});