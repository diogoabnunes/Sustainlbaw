<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = "event";
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'start_date', 'end_date', 'publication_date', 'price', 'name', 'image_path',
        'description', 'location', 'editor'
    ];

    protected $dates = ['start_date', 'end_date', 'publication_date'];

    public function location()
    {
        return Location::find($this->location);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor', 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_category', 'event_id', 'event_category_id');
    }
    public static function getMostRecent($number)
    {
        return Event::orderBy('start_date')->whereDate('start_date', '>=', Carbon::today()->toDateString())->take($number)->get();
    }
}
