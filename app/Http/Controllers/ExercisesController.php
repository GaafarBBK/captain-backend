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
            'image_url' => ['string'],
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


    public function search(Request $request)
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


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['string'],
            'description' => ['string'],
            'target_muscle' => ['string'],
            'equipment' => ['string'],
            'sets' => ['integer'],
            'reps' => ['integer'],
            'image_url' => ['string'],
            'status' => ['string','in:Pending,Completed'],
            'isPublic' => ['boolean'],
        ]);

        $exercise = Exercises::find($id);

        if (!$exercise){
            return response()->json(['error' => 'Exercise not found'], 404);
        }

        $exercise->update($request->all());

        return response()->json([
            'message' => 'Exercise updated successfully',
            'exercise' => $exercise
        ]);

    }





    

    
}