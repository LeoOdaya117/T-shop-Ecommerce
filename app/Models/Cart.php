<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    use HasFactory;

    public function variant(){

        return $this->belongsTo(ProductVariant::class, 'variant_id');

    }
    public function product(){

        return $this->belongsTo(Products::class, 'product_id');
        
    }
}
