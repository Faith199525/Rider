<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\ApiBaseController;
use App\Models\User;
use App\Models\Rider;
use App\Models\Driver;
use \Illuminate\Support\Str;

class AuthController extends ApiBaseController
{

    public function index()
    {
        return $this->successResponse(["message" => "Welcome to Riders Api"],'', 200);
    }

    public function register(CreateUserRequest $request)
    {
        $input = $request->all(['name', 'email', 'password', 'type']);
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        if($request->type == 'rider'){
            $rider = new Rider;
            $rider->user_id = $user->id;
            $rider->save(); 
        }else{
            $driver = new Driver;
            $driver->user_id = $user->id;
            $driver->save();
        }
        return $this->successResponse($user,'User Created', 201);
    }

    public function login(LoginRequest $request)
    {
        $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials, $remember_me)) {

            return $this->errorResponse('Email and password does not match', 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $responsePayload = [
            "user" => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ];

        return $this->successResponse($responsePayload,'Login Successful', 200);

    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
        }
        return $this->successResponse(null, 'Logout succesfully');
    }

}
