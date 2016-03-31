<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

	public function store(CreatePostRequest $request) {
		if(Auth::check()) {
			$post = new Post;
			$post->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
			$post->title = $request->input('title');
			$post->content = $request->input('content');
			$post->author_id = Auth::id();
			$post->active = 1; //IMPLTEMENT DRAFT FUNCTIONALITY LATER
			$post->slug = str_slug($post->title);
			$post->save();

			return redirect('home')->with('message-success', 'Post created successfully');
		}
		return redirect('/')->with('message', 'You don\'t have the required permissions');
	}

	public function edit($id) {
		$post = Post::find($id);
		if(!empty($post) && Auth::user()->id == $post->author_id) {
			return view('posts.edit')->with('post', $post);
		} else {
			return redirect('/')->with('message', 'You don\'t have the required permissions');
		}
	}

	public function update(Request $request, Post $post) {
		if(!empty($post)) {
			if($post->getAuthor->id == Auth::id()) {
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
			if($post->author_id == Auth::id()) {
				$post->delete();
				return redirect('home')->with('message-success', 'Post removed successfully');
			} else {
	    		return redirect('/')->with('message', 'You don\'t have the required permissions');
			}
		}
	    return redirect('/')->with('message', 'Post not found');
	}
}
