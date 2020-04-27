<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
    	'title',
    	'first_name',
    	'last_name',
    	'item_numbers',
    	'attendant_doctor',
    	'referral',
    	'date_of_service',
    	'location_of_service',
    	'notes',
    	'status',
    ];
}
