<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'slug', 'active', 'created_at', 'update_at'
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    public function getAuthor() {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function getComments() {
        return $this->hasMany('App\Comment', 'on_post', 'id');
    }
}
