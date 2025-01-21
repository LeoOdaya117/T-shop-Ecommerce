<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the specified columns
            $table->dropColumn(['category', 'brand', 'size', 'price', 'color', 'stock']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Re-add the columns if rolling back
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('brand')->nullable();
            $table->string('size')->nullable();
            $table->double('price', 8, 2);
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);
        });
    }
};
