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

Route::group(['middleware' => 'web'], function () {
    Route::auth();
	Route::get('/', function() {
		return view('welcome');
	});

    //get most recent posts on dashboard
    Route::get('/home', 'PostController@index');
    Route::get('/home', ['as' => 'home', 'uses' => 'PostController@index']);

    //user profilfe
    Route::get('/user/{id}', 'UserController@user')->where('id', '[0-9]+');

    //update user profile
    Route::post('/user/update/{id}', 'UserController@update')->where('id', '[0-9]+');

    //users posts
    Route::get('/user/{id}/posts', 'UserController@getUserPosts')->where('id', '[0-9]+');

    //users comments
    Route::get('/user/{id}/comments', 'UserController@getUserComments')->where('id', '[0-9]+');

    //store the new post
    Route::get('/post/create', 'PostController@create');

    //create a new post
    Route::post('/post/create', ['as' => 'create_post', 'uses' => 'PostController@store']);

    //edit post
    Route::get('/post/edit/{id}', 'PostController@edit')->where('id', '[0-9]+');
    Route::post('/post/edit', 'PostController@update');

    //Destroy post
    Route::get('/post/destroy/{id}', 'PostController@destroy');

    //show post
    Route::get('/post/{slug}', 'PostController@show');

    //create comment
    Route::post('/comment/create/{slug}', 'CommentController@store');

    //delete comment
    Route::get('/comment/destroy/{id}', 'CommentController@destroy');

});
