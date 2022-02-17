<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Models\PersonalAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

/*
    Scopes poin 1
    The app can process the company registration
*/
class AuthController extends Controller
{
    public function login(LoginRequest $request){
        // if already login
        $tokenExist = PersonalAccessToken::where('name', $request->email)->first();
        if($tokenExist){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'You already login'
            ], 401);
        }

        $user = User::getEmail($request->email);
        
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

    public function register(RegisterRequest $request){
        $email = User::getEmail($request->email);

        // if user is already registered
        if($email){
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'User has already been registered',
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
        
        // if user not authenticated
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
