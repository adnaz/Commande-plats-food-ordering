<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    /*
    * Handles Registration Request
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function register(Request $request)
   {
       

       $user = User::create([
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'email' => $request->email,
           'password' => $request->password,
       ]);

       $token = $user->createToken('token')->accessToken;

       return response()->json(['token' => $token], 200);
   }

   /**
    * Handles Login Request
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function login(Request $request)
   {
       $credentials = [
           'email' => $request->email,
           'password' => $request->password
       ];

       if (auth()->attempt($credentials)) {
           $token = auth()->user()->createToken('TutsForWeb')->accessToken;
           return response()->json(['token' => $token], 200);
       } else {
           return response()->json(['error' => 'UnAuthorised'], 401);
       }
   }

   /**
    * Returns Authenticated User Details
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function details()
   {
       return response()->json(['user' => auth()->user()], 200);
   }
}
