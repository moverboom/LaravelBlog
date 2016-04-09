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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPosts() {
        return $this->hasMany('App\Post', 'author_id', 'id');
    }

    public function getComments() {
        return $this->hasMany('App\Comment', 'from_user', 'id');
    }
}
