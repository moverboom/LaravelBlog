<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'title', 'content', 'slug', 'active', 'created_at', 'update_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    public function getAuthor() {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

    public function getComments() {
        return $this->hasMany('App\Comment', 'on_post', 'id');
    }
}
