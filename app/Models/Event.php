<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'location_name',
        'location_street',
        'location_city',
        'location_zipcode',
        'registration',
    ];
}
