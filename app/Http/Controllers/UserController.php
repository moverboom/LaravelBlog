<?php

namespace App\Http\Controllers;

use App\Post;
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
    	$user = User::find($userid);
    	if(empty($user)) {
            return redirect('home')->with('message', 'User not found');
    	} else if(Auth::id() == $userid) {
    		return view('user.edit')->with('user', $user);
    	} else if(Auth::check()) {
    		return view('user.profile')->with('user', $user);
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
			$user->update([
				$request->input('name'),
				$request->input('email')
			]);
    		return redirect()->back()->with('user', $user);
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
		$user = User::find($userid);
        if(!empty($user)) {
            return view('home')->with('posts', User::getPaginatedPosts($userid))->with('user', $user);
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
		$user = User::find($userid);
        if(!empty($user)) {
            return view('user.comments')->with('user', $user);
        }
    }
}
