<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingOptions extends Model
{
    use HasFactory;
    protected $table = "shipping_option";

    protected $fillable = [
        'name',
        'carrier',
        'min_days',
        'max_days',
        'cost',
        'status',
    ];
}
