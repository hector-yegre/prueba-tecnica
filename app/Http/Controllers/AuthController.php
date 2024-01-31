<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostAuthRequest;
use App\Http\Requests\storeRegister;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

 

class AuthController extends Controller
{
 
    public function login(PostAuthRequest $request){

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'ok' => false,
                'msg'=>'Usuario o contraseña invalido'
            ],404);
        }

        $user = User::where('email',"$request->email")->firstOrFail();
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return response()->json([
            'message'=>'Logeado',
            'token'=>$token,
            'token_type'=>'bearer',
            'user'=>$user
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'ok'=>true,
            'msg'=>'Exit Todos los token han sido borrados'
        ],200);
    }
    
    public function sheck(){
        if(Auth::check()){
            return response()->json([
                'ok'=>true,
            ],200);
        } 
    }

    public function register (storeRegister $request){
        try{
            $user = User::where('email',$request->email)->first();
            if($user){
                return response()->json([
                        'message'=>'Usuario ya registrado',
                        'status' =>404,
                        'error'  =>true,
                        'data'   =>[],
                    ],404);
            }
            $user = User::create($request->all());
            return response()->json([
                'message'=>'Registro exitoso',
                'status' =>201,
                'error'  =>false,
                'data'   =>$user,
            ],201);
            // ApiResponse::success('Registro Exitoso',201,$user);

        } catch (\Exception $e) {
            return response()->json([
                'msg'=> 'Contact Your Administrator'.$e->getMessage()
            ],500);
        }

    }
}
