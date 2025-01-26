<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderTracking;
class Orders extends Model
{
    protected $table = 'orders';

    use HasFactory;

    public function tracking()
    {
        return $this->hasMany(OrderTracking::class, 'order_id')->orderBy('updated_at', 'desc');
    }
}
