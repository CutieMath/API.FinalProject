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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Routes for the simple login and register
Route::post('login', 'User\UserController@login');
Route::post('register', 'User\UserController@register');


// Routes for operations
Route::group(['middleware' => 'auth:api'], function(){
	// See user details
	Route::post('details', 'User\UserController@details');
	// Manage bills
	Route::resource('upload_new_bill', 'Bill\BillController', ['except' => ['create', 'edit']]);
});


