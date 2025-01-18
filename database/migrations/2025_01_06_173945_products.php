<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products',function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('descrption');
            $table->text('image');
            $table->float('price');

            $table->string('category')->nullable()->after('sku');
            $table->string('brand')->nullable()->after('category');
            $table->string('size')->nullable()->after('brand');
            $table->string('color')->nullable()->after('size');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('color');
            $table->float('discount')->default(0)->after('status');
            $table->integer('stock')->default(0)->after('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
