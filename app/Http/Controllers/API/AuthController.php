<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
    Scopes poin 1
    The app can process the company registration
*/
class AuthController extends Controller
{
    public function login(Request $request){
        
        $user = User::where('email', $request->email)->first();
        
        // if email and password are not match
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Your credential are not match'
            ], 401);
        }

        // if email and password are match
        // create token to login
        $token = $user->createToken($request->email)->plainTextToken;
 
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Login successfully',
            'user'      => $user,
            'token'     => $token
        ], 200);
    }

    public function register(Request $request){
        $email = User::where('email', $request->email)->first();

        // if user is already registered
        if($email){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'User is already registered',
            ], 400);
        }

        // if user not registered
        // create new user
        if($request->role == 'company'){
            // if request role is company
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'company',
            ]);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'applicant',
            ]);
        }

        // create token to login
        $token = $user->createToken($request->email)->plainTextToken;
        
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Register successfully',
            'user'      => $user,
            'token'     => $token
        ], 200);
    }

    public function logout(){
        // get data authenticated user
        $user = Auth::user();
        
        if(!$user){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You need to login first',
            ], 401);
        }

        // delete token autehenticated user
        $user->currentAccessToken()->delete();
        return response()->json([
            'status'    => 'Success',
            'message'   => 'Logout successfully',
        ], 200);
    }
}
