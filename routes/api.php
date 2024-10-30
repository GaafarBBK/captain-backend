<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptainSubscribersController;
use App\Http\Controllers\CaptainSubscriptionsController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\SetController;

Route::post("register",[UserController::class,"store"]);
Route::post("login",[UserController::class,"login"]);


Route::middleware(['auth:api'])->group(function () {

    Route::put("user/update",[UserController::class,"update"]);
    Route::get("user/info",[UserController::class,"getUser"]);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('refresh', [UserController::class, 'refresh']);


    Route::post("sub/create",[CaptainSubscriptionsController::class,"store"]);
    Route::get("sub/show",[CaptainSubscriptionsController::class,"show"]);
    Route::put("sub/update/{id}",[CaptainSubscriptionsController::class,"update"]);
    // not finished
    Route::delete("sub/delete/{id}",[CaptainSubscriptionsController::class,"destroy"]);

    Route::post("sub/buy",[CaptainSubscribersController::class,"buySubscription"]);
    Route::get("sub/listUsers",[CaptainSubscribersController::class,"showSubscribers"]);


    Route::post("workout/create",[WorkoutController::class,"create"]);
    Route::get("workout/show",[WorkoutController::class,"showWorkout"]);
    Route::put("workout/update",[WorkoutController::class,"updateWorkout"]);
    Route::post("workout/addExercises",[WorkoutController::class,"attachExercises"]);
    Route::delete("workout/removeExercises",[WorkoutController::class,"detachExercises"]);
    Route::get("workout/showExercises",[WorkoutController::class,"showExercises"]);
    

    Route::get("exercise/search",[ExercisesController::class,"search"]);
    Route::post("exercise/create",[ExercisesController::class,"create"]);
    Route::put("exercise/update",[ExercisesController::class,"update"]);

    Route::post("set/create",[SetController::class,"create"]);
    Route::get("set/show",[SetController::class,"show"]);
    Route::put("set/update",[SetController::class,"update"]);


    Route::post("dailylog/store",[DailyLogController::class,"store"]);
    Route::get("dailylog/show",[DailyLogController::class,"getLog"]);


});