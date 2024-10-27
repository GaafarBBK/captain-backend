<?php

namespace App\Http\Controllers;

use App\Models\CaptainSubscription;
use Illuminate\Http\Request;

class CaptainSubscriptionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'duration_in_weeks' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'isAvailable' => ['boolean'],
        ]);


        if (!auth('api')->user()->Captain->id){
            return response()->json(['error' => 'User is NOT a captain'], 401);
        }

        $subscription = CaptainSubscription::create([
            'captain_id' => auth('api')->user()->Captain->id,
            'duration_in_weeks' => $request->duration_in_weeks,
            'price' => $request->price,
            'isAvailable' => $request->isAvailable ?? true,
        ]);

        return response()->json([
            'message' => 'Subscription created successfully',
            'subscription' => $subscription
        ], 201);
        
    }


    public function show()
    {
        $subscriptions = 
        CaptainSubscription::where('captain_id', auth('api')->user()->Captain->id)->get();

        return response()->json([
            'subscriptions' => $subscriptions
        ]);
    }


    public function update($id, Request $request)
    {
        $input = $request->validate([
            'duration_in_weeks' => ['integer'],
            'price' => ['integar'],
            'isAvailable' => ['boolean'],
        ]);

        $subscription = CaptainSubscription::find($id)->first();

        if ($subscription->captain_id != auth('api')->user()->Captain->id){
            return response()->json(['error' => 'Subscription not found'], 404);
        }

        
        $subscription->update($input);

        return response()->json([
            'message' => 'Subscription updated successfully',
            'id' => $subscription->id,
        ], 201);
    } 

                                

    // not finished
    public function destroy($id)
    {
        auth('api')->user()->captain()->CaptainSubscription->where('id', $id)->delete();

        return response()->json([
            'message' => 'Subscription deleted successfully'
        ], 200);

    }


    
}
