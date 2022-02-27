<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "location";
    protected $primaryKey = 'location_id';

    protected $fillable = [
        'address', 'zip_code', 'dcp_ip'
    ];

    public function dcp()
    {
        return $this->belongsTo(Dcp::class, 'dcp_id', 'dcp_id');
    }
}
