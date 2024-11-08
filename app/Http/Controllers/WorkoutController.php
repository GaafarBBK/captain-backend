<?php

namespace App\Http\Controllers;

use App\Models\CaptainSubscribers;
use App\Models\Exercises;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{

    public function isSubActive($user_id)
    {
        $userSubscribed = CaptainSubscribers::where('captain_id', auth('api')->user()->Captain->id)
                                            ->where('user_id', $user_id)
                                            ->first();

        if (!$userSubscribed || !$userSubscribed->isActive)
        {
            return false;
        }

        return true;
    }

    public function findWorkoutByDate($date, $user_id)
    {
        $workout = Workout::where('user_id', $user_id)
                            ->where('date', $date)
                            ->first();

        return $workout;
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => ['string'],
            'date' => ['required', 'date'],
            'status' => ['string','in:Pending,Completed'],

            'user_id' => ['integer'],
        ]);

        // if user_id is provided, then the captain is creating a workout for an athlete
        if ($request->user_id)
        {
            if(!$this->isSubActive($request->user_id))
            {
                return response()->json(['error' => 'Athlete is NOT subscribed to this captain.'], 401);
            }
            
            if ($this->findWorkoutByDate($request->date, $request->user_id))
            {
                return response()->json(['error' => 'Workout already exists for this user on this date.'], 401);
            }

            $workout = Workout::create([
                'user_id' => $request->user_id,
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
       
        // if user_id is not provided, then the athlete is creating a workout for himself
        if ($this->findWorkoutByDate($request->date, auth('api')->user()->id))
        {
            return response()->json(['error' => 'Workout already exists for this user on this date.'], 401);
        }

        $workout = Workout::create([
            'user_id' => auth('api')->user()->id,
            'captain_id' => auth('api')->user()->Captain->id ?? null,
            'title' => $request->title,
            'date' => $request->date,
            'status' => $request->status ?? 'Pending',
        ]);

        return response ()->json([
            'message' => 'Workout created successfully',
            'workout' => $workout
        ], 201);
    }

    

    public function showWorkout(Request $request)
    {
        $request->validate([
            'date' => ['required','date'],
            'user_id' => ['integer'],
        ]);
        
        if(!$request->user_id)
        {
            $workout = $this->findWorkoutByDate($request->date, auth('api')->user()->id);

            return response()->json([
                'workout' => $workout
            ]);
        }
        $workout = $this->findWorkoutByDate($request->date, $request->user_id);

        return response()->json([
            'workout' => $workout
        ]);
    }

    public function updateWorkout(Request $request)
    {
       
        $newData = $request->validate([
            'currentDate' => ['required','date'],
            'date' => ['date'],
            'title' => ['string'],
            'status' => ['string','in:Pending,Completed'],
            'user_id' => ['integer'],
        ]);

        if ($request->user_id)
        {
            
            if(!$this->isSubActive($request->user_id))
            {
                return response()->json(['error' => 'Athlete is NOT subscribed to this captain.'], 401);
            }
        
            $workout = Workout::where('user_id', $request->user_id)
                            ->where('date', $request->currentDate)
                            ->first();

            if (!$workout)
            {
                return response()->json(['error' => 'Workout not found'], 404);
            }

            $workout->update($newData);

            return response()->json([
                'message' => 'Workout updated successfully.',
                'workout' => $workout
            ], 201);
        }
        
        
        $workout = $this->findWorkoutByDate($request->currentDate, auth('api')->user()->id);

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }
        
        $workout->update($newData);

        return response()->json([
            'message' => 'Workout updated successfully.',
            'workout' => $workout
        ], 201);
    }


    // not finished
    public function deleteWorkout(Request $request)
    {
        $workout = Workout::find($request->workout_id);
        $workout->delete();

        return response()->json([
            'message' => 'Workout deleted successfully',
        ]);
    }


    public function attachExercises(Request $request)
    {
        $request->validate([
            'exercises_name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'user_id' => ['integer'],
        ]);

        $exercise = Exercises::where('name', $request->exercises_name)->first()->id;

        

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->orWhere('user_id', $request->user_id)
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        $workout->exercises()->attach($exercise);

        return response()->json([
            'message' => 'Exercises added to workout successfully.',
            'workout' => $workout->exercises
        ], 201);
    }

    public function detachExercises(Request $request)
    {
        $request->validate([
            'exercises_name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'user_id' => ['integer'],
        ]);

        $exercise = Exercises::where('name', $request->exercises_name)->first()->id;

        $workout = Workout::where('user_id', auth('api')->user()->id)
                            ->orWhere('user_id', $request->user_id)
                            ->where('date', $request->date)
                            ->first();
        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        $workout->exercises()->detach($exercise);

        return response()->json([
            'message' => 'Exercises removed from workout successfully.',
            'workout' => $workout->exercises
        ], 201);
    }
   
   
    public function showExercises(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'user_id' => ['integer'],
        ]);

        $workout = Workout::where(function($query) use ($request) {
                                $query->where('user_id', auth('api')->user()->id)
                                      ->orWhere('user_id', $request->user_id);
                            })
                            ->where('date', $request->date)
                            ->first();

        if (!$workout)
        {
            return response()->json(['error' => 'Workout not found'], 404);
        }

        $exercises = $workout->exercises()->with('sets')->get(['name', 'status'])->makeHidden('pivot');

        return response()->json([
            'workout_date' => $workout->date,
            'exercises' => $exercises
        ]);
    }
}
