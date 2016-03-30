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

    public function getUser() {
        return $this->belongsTo('App\User', 'from_user', 'id');
    }

    public function getPost() {
        return $this->belongsTo('App\Post', 'on_post', 'id');
    }
}
