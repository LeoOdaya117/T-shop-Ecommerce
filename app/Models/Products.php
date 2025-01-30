<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;


class Products extends Model
{
    protected $table = 'products';

    use HasFactory;

    // In Products model

    public function category()
    {
        return $this->belongsTo(Category::class, 'category'); // 'category_id' is the foreign key
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class,'brand');
    }



    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'product_id');
    }

    

    

}
