<?php

namespace App\Http\Controllers;

Use App\Comment;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentRequest;


class CommentController extends Controller
{
    //user must be loggin in to see any posts
    public function __construct()
    {
        //redirecht to login page
        $this->middleware('auth');
    }

    // public function getUserComments($id) {
    // 	$comments = Comment::where('from_user', $id)->orderBy('created_at', 'desc')->paginate(10);
    // 	if(!empty($comments)) {
    // 		return view ('comments.index')->with('comments', $comments);
    // 	}
    // }

    public function create(CreateCommentRequest $request, $slug) {
        $comment = new Comment();
    	$comment->content = $request->input('content');
    	$comment->on_post = $request->input('on_post');
       	$comment->from_user = $request->input('from_user');
        $comment->save();
        return redirect('/post/'.$slug);
    }
}
