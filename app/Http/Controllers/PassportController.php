<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken($user->email)->accessToken;

        return response()->json([
            'Success' => true,
            'Access Token' => $token,
            'User' => $user
        ], 200);
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
            $token = auth()->user()->createToken(auth()->user()->email)->accessToken;
            return response()->json([
                'Success' => true,
                'Access Token' => $token,
                'User' => auth()->user()
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json([
            'Success' => true,
            'user' => auth()->user()
        ], 200);
    }
}