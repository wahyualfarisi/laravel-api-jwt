<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    /**
     * Auth Controller construct
     */
    public function __construct()
    {
        $this->middleware(['auth:api'], [
            'except' => ['login','register']
        ]);
    }

    public function register(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ];

        $user = User::create($data);

        if($user){
            $token = auth()->login($user);
            return $this->respondWithToken($token);
        }
    }

    public function login(Request $req)
    {
        $this->validate($req, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email','password']);

        if(auth()->validate($credentials)){
            $token = auth()->attempt($credentials);
          
            return $this->respondWithToken($token);
        }

        return response()->json([
            'error' => 'UnAuthorized Allowed'
        ], 401);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function me()
    {
        return response()->json(['data' => auth()->user(),'status' => 200], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    protected function respondWithToken($token)
    {
        $data = $token;
        return response()->json([
            'your_token' => $token,
            'status'     => 200,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    


}
