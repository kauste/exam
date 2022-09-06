<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const STATES = [
        0 => 'New',
        1 => 'Accepted',
        2 => 'Canceled',
        3 => 'Delivered'
    ];
}
