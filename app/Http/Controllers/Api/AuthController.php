<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login
   public function login(Request $request){
    // validate
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // get user by email
    $user = User::where('email',$request->email)->first();

    // check  if user exist
    if (!$user) {
        return response()->json([
            'message' => 'User Not Found'
        ], 404);
    }
    // check if password is correct
    if (!Hash::check($request->password,$user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // generate token
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'access_token' => $token,
        'user'=>$user,
    ],200);
    
   }

   public function register(Request $request) {
    // validate
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required'
    ]);

    // create 
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'access_token' => $token,
        'user'=>$user,
    ],201);
   }

//    logout
public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'message' => 'Logged Out'
    ], 200);

}

}
