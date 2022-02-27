<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "category";
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name', 'image_path'
    ];

    public function blog_posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_post_id');
    }

    public function event_posts()
    {
        return $this->hasMany(Event::class, 'event_post_id');
    }
}