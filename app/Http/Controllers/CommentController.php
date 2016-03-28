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

    public function store(Request $request, Post $post) {
        if(!empty($post)) {
            $comment = new Comment;
            $comment->content = $request->input('content');
            $comment->on_post = $post->id;
            $comment->from_user = Auth::id();
            if ($comment->save()) {
                return redirect('/post/' . $post->slug);
            }
        }
        return redirect()->back()->with('message', 'Post not created');
    }

    public function update(CreateCommentRequest $request) {

    }

    public function destroy($id) {
        $comment = Comment::find($id);
        if(!empty($comment) && Auth::user()->id == $comment->from_user) {
            $comment->delete();
            return redirect()->back()->with('message-success', 'Comment remove successfully');
        }
        return redirect()->back()->with('message', 'You don\'t have te required permissions');
    }
}
