<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    /**
     * Attributes which are mass assignable
     *
     * @var array
     */
    protected $fillable = ['user_id', 'post_id', 'created_at', 'updated_at'];

    /**
     * Attributes which are not mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Attributes hidden from arrays
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * Returns the user who 'made' the Like
     *
     * @return User
     */
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Returns the Post the Like belongs o
     *
     * @return Post
     */
    public function getPost() {
        return $this->belongsTo('App\Models\Post\Post', 'post_id', 'id');
    }
}
