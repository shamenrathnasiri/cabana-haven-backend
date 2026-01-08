<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'intials',
        'identiy_number',
        'contact',
        'checking_date',
        'checkout_date',
        'room_type',
        'number_of_guest',
        'status',
    ];
}
