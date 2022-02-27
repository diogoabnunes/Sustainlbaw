<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "product";
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'vendor_id', "name", 'image_path'
    ];

    public function vendor()
    {
        return $this->belongsTo(Location::class, 'vendor_id', 'vendor_id');
    }
}
