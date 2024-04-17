<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $username = $request->name;
        $email    = $request->email;
        $password = $request->password;
        
        try{
            User::create([
                        'name'=>$username,
                        'email'=>$email,
                        'password'=>Hash::make($password
                    )]);
            return response([
                'message'=>'registered'
            ],status:201);
        }catch(Exception $exception){
            return response([
                'message'=>'not accept'
            ],status:406);
        }
    }
    public function login(Request $request){
        // $credentials = ;
        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'message'=>'not accept'
            ],status:406);
        }

        $user = Auth::user();
        // $token = $user->createToken('token')->plainTextToken;
        $token = $user->createToken('mytoken')->plainTextToken;
        $cookie  = cookie('jwt',$token,1);// 3day*3
        return response([
            'message'=>'Login success',
            'token'=>$token,
            'user'=>$user,
            'status'=>200
        ])->withCookie($cookie);

    }
    public function index(){
        return response([
            'user'=>Auth::user()
        ],status:200);
    }
    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response([
            'message'=>'success',
        ])->withCookie($cookie);
    }
   
}
