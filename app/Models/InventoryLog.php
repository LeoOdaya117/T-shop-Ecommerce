<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $table ='inventory_logs';
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id'); // 'product_id' is the foreign key
    }
}
