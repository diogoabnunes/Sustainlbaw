<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "blog_category";
    protected $primaryKey = 'blog_category_id';

    protected $fillable = [
        'blog_category_id', 'blog_post_id'
    ];

    public function blog_posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_post_id');
    }

    public function blog_category()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public static function getAllCategories(){
        return BlogCategory::join('category', 'blog_category.blog_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id','category.name']);
    }



}