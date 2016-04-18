<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePostRequest as CreatePostRequest;


class PostController extends Controller
{
    private $MESSAGE_ERROR_PERMISSIONS = "You don't have the required permissions";

	/**
	 * User must be authorized to use any of these methods
	 *
	 * PostController constructor.
	 */
	public function __construct()
	{
		//redirect to login page
	    $this->middleware('auth');
	}

	/**
	 * Index view with paginated posts
	 * Posts are ordered by creation date and paginated by 10
	 *
	 * @return home with posts array
	 */
	public function index() {
		$posts = Post::where('active', 1)->orderBy('created_at', 'desc')->paginate(15);
		return view('home')->with('posts', $posts);
	}

	/**
	 * Returns the view to create a new post
	 * The only requirement to create a post it that
	 * a user must be logged in (see constructor)
	 *
	 * @return posts.create
	 */
	public function create() {
		return view('posts.create');
	}

	/**
	 * Stores the submitted data as a new post
	 *
	 * @param CreatePostRequest $request
	 * @return posts.show which shows the created post with confirm message
	 */
	public function store(CreatePostRequest $request) {
        if($request->input('action') == 'Post') {
            return $this->publish($request->all());
        } else if ($request->input('action') == 'Save') {
            return $this->draft($request->all());
        }
	}

    /**
     * Publishes a Post
     *
     * @param array $data
     * @return mixed
     */
    private function publish(array $data) {
        $data['author_id'] = Auth::id();
        $post = Post::create($data);
        return redirect('/post/'.$post->slug)->with('message-success', 'Post created successfully');
    }

    /**
     * Saves a Post as draft
     *
     * @param array $data
     */
    private function draft(array $data) {
        $data['author_id'] = Auth::id();
        Post::draft($data);
        return redirect()->action('UserController@getUserDrafts', [Auth::id()]);
    }

    /**
     * Publishes a draft
     *
     * @param Request $request
     * @param Post $post draft from database
     */
    public function publishDraft(Request $request, Post $post) {
        if($post->exists && $post->active == 0) {
            $request['active'] = Post::POSTED;
            $this->update($request, $post);
        }
    }

    /**
     * Return the view to edit a post
     * Also checks if the user who made the request is the author
     *
     * @param $id Post to edit
     * @return posts.edit with post if valid request, else home
     */
	public function edit($id) {
		$post = Post::find($id);
		if(!empty($post) && Auth::user()->id == $post->author_id) {
            if($post->active == 1) {
                return view('posts.edit')->with('post', $post);
            } else if ($post->active == 0) {
                return view('posts.draft')->with('post', $post);
            }
		}
		return redirect('/')->with('message', $this->MESSAGE_ERROR_PERMISSIONS);
	}

    /**
     * Saves the edited post
     *
     * @param Request $request submitted data
     * @param Post $post original post
     * @return posts.show with post if success
     */
    public function update(Request $request, Post $post) {
        if ($post->getAuthor->id == Auth::id()) {
            $post->update($request->all());
            return redirect('/post/'.$post->slug)->with('message-success', 'Post updated successfully');
        }
        return redirect('/')->with('message', $this->MESSAGE_ERROR_PERMISSIONS);
    }

    /**
     * Shows a post
     *
     * @param $slug Post to show
     * @return posts.show with post
     */
	public function show($slug) {
		$post = Post::where('slug', $slug)->first();
		if(!empty($post)) {
			return view('posts.show')->with('post', $post);
		}
		return redirect()->back()->with('message', 'Post not found');
	}

    /**
     * Destroys a post (also in database)
     * Also check if the user making the request if the author
     *
     * @param $id Post to destroy
     * @return home with success message if valid request
     */
	public function destroy($id) {
		$post = Post::find($id);
		if(!empty($post)) {
			if($post->author_id == Auth::id()) {
				$post->delete();
				return redirect('home')->with('message-success', 'Post removed successfully');
			} else {
	    		return redirect('/')->with('message', $this->MESSAGE_ERROR_PERMISSIONS);
			}
		}
	    return redirect('/')->with('message', 'Post not found');
	}
}
