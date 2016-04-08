<?php

namespace App\Http\Controllers;

use App\Post;
Use App\Comment;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateCommentRequest;


class CommentController extends Controller
{
    //user must be loggin in to see any posts
    public function __construct()
    {
        //redirect to login page
        $this->middleware('auth');
    }

    /**
     * stores a new comment
     *
     * @param Request $request submitted data
     * @param Post $post Post to comment on
     * @return returns back if success
     */
    public function store(Request $request, Post $post) {
        if(!empty($post)) {
            $comment = new Comment;
            $comment->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
            $comment->content = $request->input('content');
            $comment->on_post = $post->id;
            $comment->from_user = Auth::id();
            if ($comment->save()) {
                return redirect()->back()->with('message-success', 'Comment created');
            }
        }
        return redirect()->back()->with('message', 'Comment not created');
    }

    /**
     * Updates a comment
     * NOT IMPLEMENTED YET
     *
     * @param CreateCommentRequest $request
     */
    public function update(CreateCommentRequest $request) {
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
