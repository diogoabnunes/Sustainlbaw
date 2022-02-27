<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dcp extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = "district_county_parish";
    protected $primaryKey = 'dcp_id';

    protected $fillable = [
        'district', 'county', 'parish'
    ];
}
