<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
	//user must be loggin in to access profile details
	public function __construct()
	{
		//redirect to login page
	    $this->middleware('auth');
	}

    /**
    * Show user's details
    *
    *@param userid as Base64 identifier
    *@return view with user details
    */
    public function profile($userid) {
    	$user = $this->getUserOrFail($userid);
		if($this->isRequestedUserAuthenticatedUser($user)) {
            return view('user.edit')->with('user', $user);
        }
    	return view('user.profile')->with('user', $user);
    }

	/**
	 * Checks if the given User is the same user as the currently
	 * authenticated User
	 *
	 * @param User $user
	 * @return bool true is equal
	 */
	private function isRequestedUserAuthenticatedUser(User $user) {
		return Auth::id() == $user->id;
	}

    /**
    * Update details
    *
    *  @param $user user model
	 * @param $request request
    *  @return view with user details
    */
    public function update(Request $request, User $user) {
    	if($user->exists && $user->id == Auth::id()) {
			$user->update($request->all());
    		return redirect()->back()->with('user', $user);
    	}
		return redirect('/')->with('message', 'You don\'t have the required permissions');
    }

	/**
	 *Show user posts
	 *
	 *@param $userid as Base64 identifier
	 *@return view with posts
	 */
    public function getUserPosts($userid) {
        $user = $this->getUserOrFail($userid);
		return view('user.posts')->with('user', $user);
    }

    /**
     * Shows user drafts
     *
     * @param $userid as Base64 identifier
     * @return view with drafts
     */
    public function getUserDrafts($userid) {
        $user = $this->getUserOrFail($userid);
        return view('user.drafts')->with('user', $user);
    }

	/**
	 *
	 * Show user comments
	 *
	 * @param $userid as Base64 identifier
	 * @return view with comments
	 */
    public function getUserComments($userid) {
		return view('user.comments')->with('user', $this->getUserOrFail($userid));
    }

	/**
	 * Returns a user object for the given userid of throws an exception
	 * ModelNotFoundExceptions are automatically caught by Exceptions/Handler
	 * It redirects back when the exception is thrown
	 *
	 * @param $userid User to find
	 * @throws ModelNotFoundException When user not found
	 * @return User object
	 */
	private function getUserOrFail($userid) {
		return User::findOrFail($userid);
	}
}
