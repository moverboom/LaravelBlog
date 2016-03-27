<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Post;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;


class PostController extends Controller
{
    //user must be loggin in to see any posts
	public function __construct()
	{
		//redirecht to login page
	    $this->middleware('auth');
	}

	public function index() {
		$posts = Post::where('active', 1)->orderBy('created_at', 'desc')->paginate(10);
		return view('home')->with('posts', $posts);
	}

	public function create() {
		return view('posts.create');
	}

	public function edit($id) {
		$post = Post::where('id', $id)->first();
		if(!empty($post) && Auth::user()->id == $post->author_id) {
			return view('posts.edit')->with('post', $post);
		} else {
			Session::flash('message', "You don't have to required permissions");
    		return view('welcome');
		}
	}

	public function store(CreatePostRequest $request) {
		if(Auth::check()) {
			$post = new Post();
			$post->title = $request->input('title');
			$post->content = $request->input('content');
			$post->author_id = $request->user()->id;
			$post->active = 1; //IMPLTEMENT DRAFT FUNCTIONALITY LATER
			$post->slug = str_slug($post->title);
			$post->save();

			Session::flash('message-success', "Post created successfully");
	    	return Redirect::route('home');
    	} else {
    		Session::flash('message', "You don't have to required permissions");
	    	return Redirect::route('welcome');
    	}
	}

	public function update(CreatePostRequest $request) {
		$post = Post::where('id', $request->input('id'))->first();
		if(!empty($post)) {
			if($post->author_id == Auth::user()->id) {
				$post->title = $request->input('title');
				$post->content = $request->input('content');
				$post->save();
				Session::flash('message-success', "Post updated successfully");
	    		return Redirect::route('home');
			}
			Session::flash('message', "You don't have to required permissions");
	    	return Redirect::route('welcome');
		}
		Session::flash('message', "Post not found");
	    return Redirect::route('welcome');
	}

	public function getUserPosts($id) {
		$posts = Post::where('author_id', $id)->orderBy('created_at', 'desc')->paginate(10);
		$user = User::where('id', $id)->first();
		if(!empty($posts) && !empty($user)) {
			return view('home')->with('posts', $posts)->with('user', $user);
		}
	}

	public function destroy($id) {
		$post = Post::where('id', $id)->first();
		if(!empty($post)) {
			if($post->author_id == Auth::user()->id) {
				$post->delete();
			}
		}
	}
}
