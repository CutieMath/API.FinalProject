<?php

namespace App\Http\Controllers\User;

use Validator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth; 


class UserController extends ApiController
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

        $error['message'] = $validator->errors();
    	if ($validator->fails()) { 
            return $this->errorResponse($error, 401);
        }

        // Store data into user table
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
       
        $success['message'] =  $user->first_name." has been successfully registered";
		return $this->showSuccess($success); 
    }


    // login api
    public function login(Request $request){ 

        // Validate requests
        $validator = Validator::make($request->all(),[
            'email' => 'required|email', 
            'password' => 'required', 
        ]);
        $error['message'] = $validator->errors();
        if ($validator->fails()) { 
            return $this->errorResponse($error, 401);
        }

        // Store data
        if(Auth::attempt(['email' => request('email'), 
                          'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return $this->showSuccess($success); 
        } 
        else{ 
            $error['message'] = 'Unauthorised.';
            return $this->errorResponse($error, 401);
        } 
    }


    public function details()
    {
        $user = Auth::user();
        return $this->showOne($user);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = User::all();

        return $this->showAll($users);
        // return $users;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


}
