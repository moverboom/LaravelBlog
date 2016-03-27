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
		//redirect to login page
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
            Session::flash('message', 'User not found');
            return redirect('home');
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
    		return redirect('/')->with('message', 'You don\'t have the required permissions');
    	}
    }

    public function getUserPosts($id) {
        $user = User::find($id);
        if(!empty($user)) {
            return view('home')->with('posts', $user->getPosts)->with('user', $user);
        }
    }
}
