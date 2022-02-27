<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "blog_post";
    protected $primaryKey = 'blog_post_id';

    protected $fillable = [
        "title", 'image_path', 'content', 'publication_date', 'author', 'editor'
    ];

    protected $dates = ['publication_date'];

    public function editor()
    {
        return $this->hasOne(User::class, 'editor', 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(BlogCategory::class, 'blog_post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_post_id');
    }

    public function getBlogPosts(int $category_id)
    {
        $blog_categories = BlogCategory::find($category_id);
        return $blog_categories;
    }
}
