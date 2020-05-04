<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Routes for the simple login and register
Route::post('login', 'User\UserController@login');
Route::post('register', 'User\UserController@register');




// Routes for operations after authenticated
Route::group(['middleware' => 'auth:api'], function(){
	
	// Variables for flexible end-point
	// Bill controller
	$upload_to_genie = "upload_new_claim";
	// User controller
	$users = "users";
	$details = "me";


	// Bill
	Route::resource($upload_to_genie, 'Bill\BillController', ['except' => ['create', 'edit']]);

	// User
	// See current user detail
	Route::get($details, 'User\UserController@details');
	// Other methods in user controller
	Route::resource($users, 'User\UserController', ['except' => ['create', 'edit']]);

});


