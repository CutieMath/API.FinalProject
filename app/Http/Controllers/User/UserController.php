<?php

namespace App\Http\Controllers\User;

use Validator;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 


class UserController extends Controller
{
    public $successStatus = 200;

    // register api
    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'first_name' => 'required', 
            'last_name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
    	]);
    	if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        //$success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['message'] =  $user->first_name." has been successfully registered";
		return response()->json(['success'=>$success], $this-> successStatus); 
    }


    // login api
    public function login(){ 
        
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401);
        } 
    }


    // show user details 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
