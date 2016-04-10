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
        'id', 'author_id'
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

    /**
     * Updates a Post using the given attributes
     *
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []) {
        if(!$this->exists) {
            return false;
        }
        $this->title = $attributes['title'];
        $this->content = $attributes['content'];
        $this->slug = str_slug($attributes['title']);
        return $this->save();
    }

    /**
     * Returns the Author
     *
     * @return User
     */
    public function getAuthor() {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    /**
     * Returns all the comments on the post
     *
     * @return array with comments
     */
    public function getComments() {
        return $this->hasMany('App\Comment', 'on_post', 'id');
    }

    /**
     * Returns all the likes on this post
     *
     * @return array with likes
     */
    public function getLikes() {
        return $this->hasMany('App\Like', 'post_id', 'id');
    }

    /**
     * Retuns a boolean to indicate if a user has liked this post
     *
     * @param $userid
     * @return bool
     */
    public function hasLikeFromUser($userid) {
        foreach ($this->getLikes as $like) {
            if($like->getUser->id == $userid) {
                return true;
            }
        }
        return false;
    }
}
