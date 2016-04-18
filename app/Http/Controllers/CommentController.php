<?php

namespace App\Http\Controllers;

use App\Models\Post;
Use App\Models\Comment;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    //user must be loggin in to see any posts
    public function __construct()
    {
        //redirect to login page
        $this->middleware('auth');
    }

    /**
     * Stores a new comment
     *
     * @param Request $request submitted data
     * @param Post $post Post to comment on
     * @return returns back if success
     */
    public function store(Request $request, Post $post) {
        $request['from_user'] = Auth::id();
        $request['on_post'] = $post->id;
        Comment::create($request->all());
        return redirect()->back()->with('message-success', 'Comment created');
    }

    /**
     * Updates a comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return
     */
    public function update(Request $request, Comment $comment) {
        if($comment->exists && $comment->from_user == Auth::id()) {
            $comment->update($request->all());
        }
        return redirect()->back();
    }

    /**
     * Destroys a comment (also in database)
     * also check if the user making the request is the author
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $comment = Comment::find($id);
        if(!empty($comment) && Auth::user()->id == $comment->from_user) {
            $comment->delete();
            return redirect()->back()->with('message-success', 'Comment remove successfully');
        }
        return redirect()->back()->with('message', 'You don\'t have te required permissions');
    }
}
