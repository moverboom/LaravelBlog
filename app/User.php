<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password', 'remember_token'
    ];


    /**
     * Creates a new User and saves it in the database
     *
     * @param array $attributes
     * @return User
     */
    public static function create(array $attributes = []) {
        $user = new self;
        $user->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = bcrypt($attributes['password']);
        $user->save();
        return $user;
    }

    /**
     * Returns all user's Posts
     *
     * @return array with Posts
     */
    public function getPosts() {
        return $this->hasMany('App\Post', 'author_id', 'id');
    }

    public static function getPaginatedPosts($userId) {
        return Post::where('author_id', '=', $userId)->paginate(15);
    }

    /**
     * Returns all user's Comments
     *
     * @return array with Comments
     */
    public function getComments() {
        return $this->hasMany('App\Comment', 'from_user', 'id');
    }

    /**
     * Returns all user's Likes
     *
     * @return array with Likes
     */
    public function getLikes() {
        return $this->hasMany('App\Like', 'user_id', 'id');
    }
}
