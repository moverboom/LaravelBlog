<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


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
    *@param userid as Base64 identifier
    *@return view with user details
    */
    public function profile($userid) {
    	$user = User::where('userid', $userid)->first();
    	if(empty($user)) {
            Session::flash('message', 'User not found');
            return redirect('home');
    	} else if(Auth::user()->userid == $userid) {
    		return view('user.edit')->with('user', $user);
    	} else if(Auth::check()) {
    		return view('user.profile')->with('user', $user);
    	} else {
            return redirect('/login');
        }
    }

    /**
    *
    *Update details
    *
    *@param $user user model
     * @param $request request
    *@return view with user details
    */
    public function update(Request $request, User $user) {
    	if(!empty($user) && $user->id == Auth::id()) {
    		$user->name = $request->input('name');
    		$user->email = $request->input('email');
    		$user->save();    		
    		return Redirect::back()->with('user', $user);
    	} else {
    		return redirect('/')->with('message', 'You don\'t have the required permissions');
    	}
    }

	/**
	 *
	 *Show user posts
	 *
	 *@param $userid as Base64 identifier
	 *@return view with user details
	 */
    public function getUserPosts($userid) {
        $user = User::where('userid', $userid)->first();
        if(!empty($user)) {
            return view('home')->with('posts', $user->getPosts)->with('user', $user);
        }
    }

	/**
	 *
	 *Show user comments
	 *
	 *@param $userid as Base64 identifier
	 *@return view with user details
	 */
    public function getUserComments($userid) {
        $user = User::where('userid', $userid)->first();
        if(!empty($user)) {
            return view('user.comments')->with('user', $user);
        }
    }
}
