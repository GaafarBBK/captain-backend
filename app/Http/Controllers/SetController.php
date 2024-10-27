<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Set;

class SetController extends Controller
{

    // not finished
    public function create(Request $request)
    {
        $request->validate([
            'exercise_id' => ['required', 'integer'],
            'set_no' => ['required', 'integer'],
            'reps' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'status' => ['string','in:Pending,Completed'],
        ]);

        $set = Set::create([
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


    // not finished
    public function show()
    {
        $set = Set::where('exercise_id', auth('api')->user()->id)->get();

        return response()->json([
            'set' => $set
        ]);
    }
    
}
