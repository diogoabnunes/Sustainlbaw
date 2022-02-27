<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "vendor";
    protected $primaryKey = 'vendor_id';
    /**
     * The card this Vendor belongs to.
     */
    protected $fillable = [
        "name", 'job', 'location_id', 'description', 'image_path'
    ];

    /**
     * Get the location that owns the Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
    /**
     * Get all of the product for the Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
