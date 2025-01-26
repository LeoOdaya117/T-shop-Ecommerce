<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $table = 'order_tracking';

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id'); // Correct foreign key
    }
}
