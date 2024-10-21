<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercises;
use Illuminate\Http\Request;

class ExercisesController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'target_muscle' => ['required', 'string'],
            'equipment' => ['required', 'string'],
            'sets' => ['required', 'integer'],
            'reps' => ['required', 'integer'],
            'status' => ['string','in:Pending,Completed'],
            'isPublic' => ['boolean'],
        ]);

        $exercise = Exercises::create([
            'name' => $request->name,
            'description' => $request->description,
            'target_muscle' => $request->target_muscle,
            'equipment' => $request->equipment,
            'sets' => $request->sets,
            'reps' => $request->reps,
            'status' => $request->status,
            'isPublic' => $request->isPublic,
        ]);

        return response ()->json([
            'message' => 'Exercise created successfully',
            'exercise' => $exercise
        ], 201);

    }


    public function searchExercises(Request $request)
    {
        $request->validate([
            'name' => ['string'],
            'target_muscle' => ['string'],
            'equipment' => ['string'],
            'isPublic' => ['boolean'],
        ]);

        $exercises = Exercises::where('name', 'like', '%'.$request->name.'%')
            ->where('target_muscle', 'like', '%'.$request->target_muscle.'%')
            ->where('equipment', 'like', '%'.$request->equipment.'%')
            ->where('isPublic', $request->isPublic)
            ->get();

        return response()->json([
            'exercises' => $exercises
        ]);

    }


    public function attachExercises(Request $request)
    {
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
