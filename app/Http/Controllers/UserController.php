<?php

namespace App\Http\Controllers;

use App\Models\AthBodyInfo;
use App\Models\Captain;
use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => ['required','string'],
            'password' => ['required','string'],
        ]);
        
        $credentials = request(['email', 'password']);
        if(!$token = auth()->attempt($credentials)){
            return response()->json(['status'=> 'error'], 401);
            
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }


   public function store(Request $request){

    $newAcc = $request->validate([
        'name' => ['required','string'],
        'email' => ['required','string','unique:users,email'],
        'password' => ['required','string'],
        'avatar_url' => ['string','nullable'] ,
        'phone_number' => ['integer','nullable'] ,
        'bio' => ['string','nullable']  ,
        'role' => ['required','string','in:captain,athlete'] ,
        'experience' => ['string','nullable',],
        'gender' => ['string','nullable','in:male,female'],
        'age' => ['integer','nullable'],
        'weight' => ['integer','nullable'],
        'height' => ['integer','nullable'],
        'ath_lvl' => ['string','nullable','in:Rookie,Beginner,Intermediate,Advanced'],
        'ath_goal' => ['string','nullable','in:Gain Weight,Lose Weight,Get Fitter,Gain More Flexibility,Build Muscle'],
        'ath_body' => ['string','nullable','in:Skinny,Athletic,Muscular'],

    ]);

    $kk = User::create([
        'name' => $newAcc['name'],
        'email' => $newAcc['email'],
        'password' => Hash::make($newAcc['password']),
        'avatar_url' => $newAcc['avatar_url'] ?? null,
        'phone_number' => $newAcc['phone_number'] ?? null,
        'bio' => $newAcc['bio'] ?? null,
    ]);
    
    
    
    if ($newAcc['role'] == 'captain') {
        Captain::create([
            'user_id' => $kk->id,
            'experience' => $newAcc['experience'] 
        ]);
    } else {
        AthBodyInfo::create([
            'user_id' => $kk->id,
            'gender'=> $newAcc['gender'],
            'age' => $newAcc['age'],
            'weight' => $newAcc['weight'],
            'height' => $newAcc['height'],
            'ath_lvl' => $newAcc['ath_lvl'],
            'ath_goal' => $newAcc['ath_goal'],
            'ath_body' => $newAcc['ath_body'],
        ]);
    }

    return response()->json(['message' => 'User created successfully'], 201);
   }


   public function update(Request $request)
   {
        $newData = $request->validate([
            'name' => ['string'],
            'password' => ['string'],
            'avatar_url' => ['string'],
            'phone_number' => ['integer'],
            'bio' => ['string'],
        ]);

        auth('api')->user()->update($newData);

        return response()->json([
            'message' => 'Profile updated successfully'
        ], 200);
   }

   public function getUser()
   {
        return response()-> json([
            'user info' => auth('api')->user(),
            
        ]);
       
   }


   public function logout()
   {
         auth('api')->logout(true);
         return response()->json(['message' => 'User logged out successfully'], 200);
   }

   public function refresh()
   {
         return response()->json([
              'token' => auth('api')->refresh(true,true),
              'token_type' => 'bearer',
              'expires_in' => auth('api')->factory()->getTTL() * 60
         ]);
   }


   



}
