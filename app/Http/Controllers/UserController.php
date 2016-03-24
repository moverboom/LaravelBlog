<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;


class UserController extends Controller
{
	//user must be loggin in to access profile details
	public function __construct()
	{
		//redirecht to login page
	    $this->middleware('auth');
	}

    /**
    *
    *Show users' details
    *
    *@param user id $id
    *@return view with user details
    */
    public function user(Request $request, $id) {
    	$user = User::find($id);

    	if(!$user) {
    		Session::flash('message', "User not found");
    		return view('welcome');
    	} else if($user && $request->user()->id == $id) {
    		return view('user.edit')->with('user', $user);
    	}
    	else {
    		return view('user.profile')->with('user', $user);
    	}
    }

    /**
    *
    *Update details
    *
    *@param user id $id
    *@return view with user details
    */
    public function update(Request $request, $id) {
    	$user = User::find($id);

    	if($user && $request->user()->id == $id) {
    		$user->name = $request->input('name');
    		$user->email = $request->input('email');
    		$user->save();    		
    		return Redirect::back()->with('user', $user);
    	} else {
    		Session::flash('message', "You don't have to required permissions");
    		return view('welcome');
    	}
    }
}
