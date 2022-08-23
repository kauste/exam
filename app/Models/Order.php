<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const STATES = [
        1 => 'New',
        2 => 'Accepted',
        3 => 'Canceled',
        4 => 'Delivered'
    ];
}
