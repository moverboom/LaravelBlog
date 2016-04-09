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

    /**
     * Creates a new Post
     * Overwrites the default Eloquent create method
     *
     * @param array $attributes
     * @return Post
     */
    public static function create(array $attributes = [])
    {
        $post = new self();
        $post->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
        $post->title = $attributes['title'];
        $post->content = $attributes['content'];
        $post->slug = str_slug($attributes['title']);
        $post->author_id = $attributes['author_id'];
        $post->active = 1; //IMPLEMENT DRAFT FUNCTIONALITY LATER
        $post->save();
        return $post;
    }
    
    public function update(array $attributes = [], array $options = []) {
        if(!$this->exists) {
            return false;
        }
        $this->title = $attributes['title'];
        $this->content = $attributes['content'];
        $this->slug = str_slug($attributes['title']);
        return $this->save();
    }

    public function getAuthor() {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function getComments() {
        return $this->hasMany('App\Comment', 'on_post', 'id');
    }
}
