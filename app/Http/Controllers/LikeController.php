<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Like;
use App\Http\Requests;
use App\Models\Post\Post;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    /**
     * User must be authorized to like posts
     *
     * LikeController constructor.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Likes a Post using the Post object and authorized User
     *
     * @param Post $post
     * @return redirect back
     */
    public function like(Post $post) {
        if(! Like::where('post_id', '=', $post->id)->where('user_id', '=', Auth::id())->exists()) {
            Like::create([
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);
        } else {
            $this->unlike($post);
        }
        return redirect()->back();
    }

    /**
     * Unlikes a post using the Post object and authorized User
     *
     * @param Post $post
     * @return redirect back
     */
    public function unlike(Post $post) {
        if($post->exists) {
            Like::where('user_id', '=', Auth::id())->where('post_id', '=', $post->id)->delete();
        }
        return redirect()->back();
    }
}
