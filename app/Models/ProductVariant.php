<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\Products;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    public function product()
    {
        return $this->belongsTo(Products::class);
    }

}
