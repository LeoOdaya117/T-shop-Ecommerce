<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id'); 
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id'); 
    }
}
