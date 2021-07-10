<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','unauthorized','register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('UserName', 'password');
        if ($token = auth('api')->attempt($credentials)) {
            $user = User::where('UserName', $request->UserName)->first();
            $username = $user->UserName;
            //$user->fcm_token = $request->fcm_token;
            //$user->save();
            //login response
            $status = 200;
            $message = 'login Successfully';
            $jwt = $token;
            return response()->json(['status' => $status, 'type' => TRUE, 'token' => $jwt, 'name' => $username, 'message' => $message]);
        }else{
            $status = 200;
            $message = 'Credential Not Matched. Please Try Again.';
            return response()->json(['status' => $status, 'type' => False, 'message' => $message]);
        }
    }

    public function register(Request $request){

        $UserName = $request->UserName;
        $Password = $request->password;

        $emailExist = User::where('UserName',$UserName)->first();
        if(!$emailExist){
            $user = User::create([
                'UserName' => $UserName,
                'password' => Hash::make($Password),
                'Role' => 'User',
                'Status' => 1,
                'CreatedOn' => date('Y-m-d'),
            ]);
            if($user){
                $credentials = $request->only('UserName', 'password');
                if($token = auth('api')->attempt($credentials)){
                    $status = 200;
                    $message = 'Registered Successfully';
                    $jwt = $token;
                    return response()->json(['status' => $status, 'type' => TRUE, 'token' => $jwt, 'message' => $message]);
                }
            }else{
                return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'Something Went Wrong. Please Try Again.']);
            }
        }else{
            return response()->json(['status' => 200, 'type' => FALSE, 'message' => 'UserName Already Registered']);
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
    public function unauthorized(){
        $status = 200;
        $message = 'Not Authorized.';
        return response()->json(['status' => $status, 'type' => FALSE, 'message' => $message]);
    }

}