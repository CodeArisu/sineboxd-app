<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request) {
        /* 
        *    validates the request coming from the user
        *    and checks if the request is valid
        */
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:55',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // returns an error message if the request is invalid
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Input',
                'errors' => $validated->errors(),
            ], 403);
        }
        
        try {

            // creates a new user with the validated data
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            // creates a token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // returns the token and the user as a json response
            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Exception $e) {
            // simply returns the error message if an error occurs
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    public function login(Request $request) {
        /* 
        *    validates the request coming from the user
        *    and checks if the request is valid
        */
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // returns an error message if the request is invalid
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Invalid Input',
                'errors' => $validated->errors(),
            ], 403);
        }

        try {
            // checks if the user exists
            $credentials = ['email' => $request->email, 'password' => $request->password];

            // returns an error message if the user does not exist
            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid Credentials',
                ], 403);
            }
            // gets the user
            $user = User::where('email', $credentials['email'])->firstOrFail();

            // creates a token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // returns the token and the user as a json response
            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Exception $e) {
            // simply returns the error message if an error occurs
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 403);
        }

    }

    public function logout(Request $request) {
        // revokes the token
        $request->user()->currentAccessToken()->delete();

        // returns a success message
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

}
