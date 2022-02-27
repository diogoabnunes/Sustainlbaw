<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "order";
    protected $primaryKey = 'order_id';

    protected $fillable = [
        "event_id", 'user_id', 'date', 'code', 'number_tickets', 'total'
    ];

    protected $dates = ['date'];


    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
?>