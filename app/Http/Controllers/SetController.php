<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Set;
use App\Models\Workout;

class SetController extends Controller
{

    // not finished.. workout id and exercise id should be obtainble by relations using the date given in the request
    public function create(Request $request)
    {
        $request->validate([
            'exercise_id' => ['required', 'integer'],
            'date'=> ['required','date'],
            'set_no' => ['required', 'integer'],
            'reps' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'status' => ['string','in:Pending,Completed'],
        ]);
        
        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        $set = Set::create([
            'workout_id' => $workout->id,
            'exercise_id' => $request->exercise_id,
            'set_no' => $request->set_no,
            'reps' => $request->reps,
            'weight' => $request->weight,
            'status' => $request->status,
        ]);

        return response ()->json([~
            'message' => 'Set created successfully',
            'set' => $set
        ], 201);
    }


    public function show(Request $request)
    {
        $request->validate([
            'exercise_id' => ['required', 'integer'],
            'set_no'=> ['required', 'integer'],
            'date' => ['required', 'date'],
        ]);

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        $set = Set::where('workout_id', $workout->id)
                    ->where('exercise_id', $request->exercise_id)
                    ->where('set_no', $request->set_no)->first();

        if (!$set)
        {
            return response()->json(['error' => 'Set not found'], 404);
        }

        return response()->json([
            'set' => $set
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'set_no' => ['integer'],
            'reps' => ['integer'],
            'weight' => ['integer'],
            'status' => ['string','in:Pending,Completed'],
        ]);

        $set = Set::find($id);

        if (!$set){
            return response()->json(['error' => 'Set not found'], 404);
        }

        $set->update([
            'set_no' => $request->set_no,
            'reps' => $request->reps,
            'weight' => $request->weight,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Set updated successfully',
            'set' => $set
        ]);
    }
    
}
