<?php

namespace App\Http\Controllers;

use App\Models\CaptainSubscribers;
use App\Models\CaptainSubscription;
use Illuminate\Http\Request;

class CaptainSubscribersController extends Controller
{

    public function buySubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => ['required', 'integer'],
        ]);

        if (!CaptainSubscription::find($request->subscription_id)){
            return response()->json(['error' => 'Subscription not found'], 404);
        }

        CaptainSubscribers::create([
            'user_id' => auth('api')->user()->id,
            'captain_id' => CaptainSubscription::find($request->subscription_id)->captain_id,
            'subscription_id' => $request->subscription_id,
            'isActive' => true,
            'start_date' => now(),
            'end_date' => now()->addWeeks(CaptainSubscription::find($request->subscription_id)->duration_in_weeks),
        ]);

        return response()->json(['message' => 'Subscription bought successfully'], 201);

    }
}
