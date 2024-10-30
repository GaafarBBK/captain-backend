<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Set;
use App\Models\Workout;
use App\Models\Exercises;

class SetController extends Controller
{
    

    public function create(Request $request)
    {
        $request->validate([
            'exercises_name' => ['required', 'string'],
            'date'=> ['required','date'],
            'set_no' => ['integer'],
            'reps' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'status' => ['string','in:Pending,Completed'],
        ]);

        $exercise = Exercises::where('name', $request->exercises_name)->first();

        if (!$exercise) {
            return response()->json(['error' => 'Exercise not found'], 404);
        }

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        if(!$request->set_no)
        {
            $set_no = Set::where('workout_id', $workout->id)
                        ->where('exercises_id', $exercise->id)->count() + 1;
        }

        if (Set::where('workout_id', $workout->id)
                ->where('exercises_id', $exercise->id)
                ->where('set_no', $request->set_no)->first())
        {
            return response()->json(['error' => 'Set already exists'], 401);
        }

        $set = Set::create([
            'workout_id' => $workout->id,
            'exercises_id' => $exercise->id,
            'set_no' => $request->set_no ?? $set_no,
            'reps' => $request->reps,
            'weight' => $request->weight,
            'status' => $request->status ?? 'Pending',
        ]);

        return response()->json([
            'message' => 'Set created successfully',
            'set' => $set
        ], 201);
    }


    public function show(Request $request)
    {
        $request->validate([
            'exercises_name' => ['required', 'string'],
            'set_no'=> ['integer'],
            'date' => ['required', 'date'],
        ]);

        $exercise = Exercises::where('name', $request->exercises_name)->first();

        if (!$exercise) {
            return response()->json(['error' => 'Exercise not found'], 404);
        }

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        if (!$request->set_no)
        {
            $sets = Set::where('workout_id', $workout->id)
                        ->where('exercises_id', $exercise->id)->get();

            return response()->json([
                'sets' => $sets
            ]);
        }


        $set = Set::where('workout_id', $workout->id)
                    ->where('exercises_id', $exercise->id)
                    ->where('set_no', $request->set_no)->first();

        if (!$set)
        {
            return response()->json(['error' => 'Set not found'], 404);
        }

        return response()->json([
            'set' => $set
        ]);
    }

    public function update(Request $request)
    {
        $newData = $request->validate([
            'date' => ['required','date'],
            'exercises_name' => ['required','string'],
            'currentSet_no' => ['required','integer'],
            'set_no' => ['integer'],
            'reps' => ['integer'],
            'weight' => ['integer'],
            'status' => ['string','in:Pending,Completed'],
        ]);



        $exercise = Exercises::where('name', $request->exercises_name)->first();

        if (!$exercise) {
            return response()->json(['error' => 'Exercise not found'], 404);
        }

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }



        $set = Set::where('workout_id', $workout->id)
                    ->where('exercises_id', $exercise->id)
                    ->where('set_no', $request->currentSet_no)->first();

        if (!$set)
        {
            return response()->json(['error' => 'Set not found'], 404);
        }

        $set->update($newData);

        return response()->json([
            'message' => 'Set updated successfully',
            'set' => $set
        ]);
    }
    
}
