<?php

namespace Modules\\Rental\\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'category',
        'daily_rental_rate',
        'total_stock',
    ];
}
