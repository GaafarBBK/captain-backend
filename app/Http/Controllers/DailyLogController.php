<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyLogController extends Controller
{

    public function calcCalories($steps, $weight)
    {
        $calories = $steps * 0.04 * ($weight / 70);
        return $calories;
    }
    
    public function store(Request $request)
    {
        $request->validate(
            [
                'steps' => ['required', 'integer'],
            ]
        );

        DailyLog::updateOrCreate(
            [
                'user_id' => auth('api')->user()->id,
                'day_date' => today()->toDateString(),
            ],
            [
                'steps' => $request->steps,
                'calories' => $this->calcCalories($request->steps, auth('api')->user()->AthBodyInfo->weight),
            ]
        );

        return response()->json(['message' => 'Daily log updated successfully'], 201);
    }

    public function getLog()
    {
        $log = DailyLog::where('user_id', auth('api')->user()->id)
        ->get();

        return response()->json([
            'log' => $log
        ]);
    }

}
