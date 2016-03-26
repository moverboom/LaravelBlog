<?php

namespace App\Http\Controllers;

use Session;
use App\Post;
use Redirect;
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
		return view('/home')->with('posts', $posts);
	}

	public function create() {
		return view('posts.create');
	}

	public function store(CreatePostRequest $request) {

		$post = new Post();
		$post->title = $request->input('title');
		$post->body = $request->input('content');
		$post->author_id = $request->user()->id;
		$post->active = 1; //IMPLTEMENT DRAFT FUNCTIONALITY LATER
		$post->slug = str_slug($post->title);
		$post->save();

		Session::flash('message-success', "Post created successfully");
    	return Redirect::route('home');
	}
}
