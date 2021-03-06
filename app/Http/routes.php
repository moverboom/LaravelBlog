<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function() {

    //Call the auth() method from Router.php
    //This is where the default authentication routes such as /login /register are defined
    Route::auth();

	Route::get('/', function() {
		return view('welcome');
	});

    //get most recent posts on dashboard
    Route::get('/home', 'PostController@index');
    Route::get('/home', ['as' => 'home', 'uses' => 'PostController@index']);

    //user profilfe
    Route::get('/user/{userid}', 'UserController@profile');

    //update user profile
    Route::post('/user/update/{user}', ['as' => 'user/update', 'uses' => 'UserController@update']);

    //users posts
    Route::get('/user/{userid}/posts', ['as' => 'user/posts', 'uses' => 'UserController@getUserPosts']);

    //user drafts
    Route::get('/user/{userid}/drafts', ['as' => 'user/drafts', 'uses' => 'UserController@getUserDrafts']);

    //users comments
    Route::get('/user/{userid}/comments', ['as' => 'user/comments', 'uses' => 'UserController@getUserComments']);






    //store the new post
    Route::get('/post/create', 'PostController@create');

    //create a new post
    Route::post('/post/create', function(App\Http\Requests\CreatePostRequest $request) {
        if($request->input('action') == 'Save')
            return \App::make('App\Http\Controllers\DraftController')->store($request);
        return \App::make('App\Http\Controllers\PostController')->store($request);
    });

    //edit post
    Route::get('/post/edit/{id}', 'PostController@edit');
    Route::post('/post/edit/{post}', ['as' => 'post/update', 'uses' => 'PostController@update']);

    //Destroy post
    Route::get('/post/destroy/{id}', 'PostController@destroy');

    //show post
    Route::get('/post/{slug}', 'PostController@show');

    Route::get('/draft/edit/{id}', 'DraftController@edit');

    Route::post('/draft/edit/{draft}', function(App\Http\Requests\CreatePostRequest $request, App\Models\Post\Draft $draft) {
        if($request->input('action') == 'Publish')
            return \App::make('App\Http\Controllers\DraftController')->publish($request, $draft);
        return \App::make('App\Http\Controllers\DraftController')->update($request, $draft);
    });

    //Destroy draft
    Route::get('/draft/destroy/{id}', 'DraftController@destroy');




    //create comment
    Route::post('/comment/create/{post}', ['as' => 'comment/create', 'uses' => 'CommentController@store']);

    //update comment
    Route::post('/comment/update/{comment}', ['as' => 'comment/update', 'uses' => 'CommentController@update']);

    //delete comment
    Route::get('/comment/destroy/{id}', 'CommentController@destroy');

    //Like a post
    Route::post('/post/like/{post}', ['as' => 'post/like', 'uses' => 'LikeController@like']);

});