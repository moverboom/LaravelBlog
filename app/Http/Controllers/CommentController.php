<?php

namespace App\Http\Controllers;

Use App\Comment;
use App\Http\Requests;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function getUserComments($id) {
    	$comments = Comment::where('from_user', $id)->orderBy('created_at', 'desc')->paginate(10);
    	if(!empty($comments)) {
    		return view ('comments.index')->with('comments', $comments);
    	}
    }
}
