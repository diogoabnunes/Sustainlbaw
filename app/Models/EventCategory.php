<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "event_category";
    protected $primaryKey = 'event_category_id';

    protected $fillable = [
        'event_category_id', 'event_id'
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'event_id');
    }

    public function event_category()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public static function getAllCategories(){
        return EventCategory::join('category', 'event_category.event_category_id', '=', 'category.category_id')->distinct('category.category_id')->get(['category.category_id','category.name']);
    }
}
