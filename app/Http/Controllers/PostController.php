<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Post;
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
			return redirect('/')->with('message', 'You don\'t have the required permissions');
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

	    	return redirect('home')->with('message-success', 'Post created successfully');
    	} else {
    		return redirect('/')->with('message', 'You don\'t have the required permissions');
    	}
	}

	public function update(CreatePostRequest $request) {
		$post = Post::find($request->input('id'));
		if(!empty($post)) {
			if($post->author_id == Auth::user()->id) {
				$post->title = $request->input('title');
				$post->content = $request->input('content');
				$post->save();
				return redirect('home')->with('message-success', 'Post updated successfully');
			}
			return redirect('/')->with('message', 'You don\'t have the required permissions');
		}
		return redirect('/')->with('message', 'Post not found');
	}

	public function show($slug) {
		$post = Post::where('slug', $slug)->first();
		if(!empty($post)) {
			return view('posts.show')->with('post', $post);
		}
		Session::flash('message', 'Post not found');
		return redirect()->back();
	}

	public function destroy($id) {
		$post = Post::find($id);
		if(!empty($post)) {
			if($post->author_id == Auth::user()->id) {
				$post->delete();
				return redirect('home')->with('message-success', 'Post removed successfully');
			} else {
	    		return redirect('/')->with('message', 'You don\'t have the required permissions');
			}
		}
	    return redirect('/')->with('message', 'Post not found');
	}
}
