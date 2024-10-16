<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function login(Request $request)
   {
       $request->validate([
           'email' => ['required','string'],
           'password' => ['required','string'],
       ]);

       $credentials = request(['email', 'password']);

       if (!$token = auth('api')->attempt($credentials)) {
           return response()->json(['error' => 'Unauthorized'], 401);
        } 
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);

   }


   public function store(Request $request){

    $newAcc = $request->validate([
        'name' => ['required','string'],
        'email' => ['required','string','unique:users,email'],
        'password' => ['required','string'],
        'avatar_url' => ['nullable','string'],
        'phone_number' => ['nullable','integer'],
        'bio' => ['nullable','string'],
    ]);

    User::create([
        'name' => $newAcc['name'],
        'email' => $newAcc['email'],
        'password' => Hash::make($newAcc['password']),
        'avatar_url' => $newAcc['avatar_url'],
        'phone_number' => $newAcc['phone_number'],
        'bio' => $newAcc['bio'],
    ]);

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

        return response()->json(['message' => 'Profile updated successfully'], 200);
   }

   public function getUser()
   {
        return response()-> json([
            'user' => auth('api')->user()
        ]);
       
   }


   public function logout()
   {
         auth('api')->logout();
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

   // destroy method

   



}
