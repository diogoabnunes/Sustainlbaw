<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "comment";
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        "blog_post_id", 'user_id', 'content', 'date'
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function post(){
        return $this->hasOne(BlogPost::class, 'blog_post_id', 'blog_post_id');
    }
}
