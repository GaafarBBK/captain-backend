<?php

namespace App\Http\Controllers;

use App\Models\CaptainSubscribers;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'date' => ['required', 'date'],
            'status' => ['string','in:Pending,Completed'],

            'user_id' => ['required', 'integer'],
        ]);

        if (!CaptainSubscribers::where('captain_id', auth('api')->user()->Captain->id)->where('user_id', $request->user_id)->first()){
            return response()->json(['error' => 'User is NOT subscribed to this captain'], 401);
        }

        $workout = Workout::create([
            'user_id' => CaptainSubscribers::where('captain_id', auth('api')->user()->Captain->id)->where('user_id', $request->user_id)->first()->user_id,
            'captain_id' => auth('api')->user()->Captain->id,
            'title' => $request->title,
            'date' => $request->date,
            'status' => $request->status ?? 'Pending',
        ]);

        return response ()->json([
            'message' => 'Workout created successfully',
            'workout' => $workout
        ], 201);
    }

    

    public function show()
    {
        $workout = Workout::where('user_id', auth('api')->user()->id)->get();

        return response()->json([
            'workout' => $workout
        ]);
    }

    public function updateWorkout(Request $request)
    {
        $request->validate([
            'title' => ['string'],
            'date' => ['date'],
            'status' => ['string','in:Pending,Completed'],
        ]);

        $workout = Workout::find($request->workout_id);
        $workout->update([
            'title' => $request->title,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Workout updated successfully',
            'workout' => $workout
        ]);
    }

    public function attachExercises(Request $request)
    {
        $request->validate([
            'exercises_id' => ['required', 'integer'],
            'workout_id' => ['required', 'integer'],
        ]);

        $workout = Workout::find($request->workout_id);
        $workout->exercises()->attach($request->exercises_id);

        return response()->json([
            'message' => 'Exercises added to workout successfully',
            'workout' => $workout
        ]);
    }



    public function detachExercises(Request $request)
    {
        $workout = Workout::find($request->workout_id);
        $workout->exercises()->detach($request->exercises_id);

        return response()->json([
            'message' => 'Exercises removed from workout successfully',
            'workout' => $workout
        ]);
    }
   
   
}
