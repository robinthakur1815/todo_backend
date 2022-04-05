<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use App\Models\Todo;
use Dotenv\Validator as DotenvValidator;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){ 

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),202);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $responseArray = [];
        $responseArray['token'] = $user->createToken('MyApp')->accessToken;
        $responseArray['name'] = $user->name;
        
        return response()->json($responseArray,200);  
    }

    /// login //////

    public function login(Request $request){ 
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $responseArray = [];
            $responseArray['token'] = $user->createToken('MyApp')->accessToken;
            $responseArray['name'] = $user->name;
            
            return response()->json($responseArray,200);

        }else{
            return response()->json(['error'=>'Unauthenticated'],203);
        }
    }

    /// logout///

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
 
      /// userInfo///
    public function userInfo() 
    {
     $user = auth()->user();
     return response()->json(['user' => $user], 200);
 
    }

      /// getAllUser///
    public function getAllUser() 
    {
     $user = auth()->user();
     $user = User::all();
     return response()->json([$user], 200);
 
    }
}
