<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'created_at', 'update_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Creates a new comment
     * Overwrites the default Eloquent create method
     *
     * @param array $attributes
     * @return Comment
     */
    public static function create(array $attributes = []) {
        $comment = new self;
        $comment->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
        $comment->content = $attributes['content'];
        $comment->on_post = $attributes['on_post'];
        $comment->from_user = $attributes['from_user'];
        $comment->save();
        return $comment;
    }

    public function getUser() {
        return $this->belongsTo('App\User', 'from_user', 'id');
    }

    public function getPost() {
        return $this->belongsTo('App\Post', 'on_post', 'id');
    }
}
