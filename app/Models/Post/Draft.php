<?php

namespace App\Models\Post;


class Draft extends Post
{

    /**
     * Creates a new Post and saves it
     * Overwrites the default Eloquent create method
     *
     * @param array $attributes
     * @return Post
     */
    public static function create(array $attributes = [])
    {
        $draft = new self();
        $draft->id = substr(base64_encode(sha1(mt_rand())), 0, 11);
        $draft->title = $attributes['title'];
        $draft->content = $attributes['content'];
        $draft->author_id = $attributes['author_id'];
        $draft->save();
        return $draft;
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
        return $this->save();
    }

    /**
     * Publishes the Draft and deletes it
     *
     * @return Post resulting Post object
     */
    public function publish() {
        if($this->exists) {
            $post = Post::create($this->getDraftData());
            $this->delete();
            return $post;
        }
    }

    /**
     * Returns the Draft data
     *
     * @return array
     */
    private function getDraftData() {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'author_id' => $this->author_id
        ];
    }

    /**
     * Returns the Author
     *
     * @return User
     */
    public function getAuthor() {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

}
