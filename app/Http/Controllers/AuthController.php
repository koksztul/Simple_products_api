<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['email'] =  $user->email;
   
        return response()->json($success, 201);
    }
   

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] = $user->createToken('MyLeadApp')->plainTextToken; 
            $success['email'] = $user->email;
   
            return response()->json($success, 200);
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401);
        } 
    }
}
