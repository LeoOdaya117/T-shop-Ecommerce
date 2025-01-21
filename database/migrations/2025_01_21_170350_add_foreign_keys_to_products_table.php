<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add foreign key for category
            $table->foreign('category')->references('id')->on('category')->onDelete('set null');

            // Add foreign key for brand
            $table->foreign('brand')->references('id')->on('brand')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['category']);
            $table->dropForeign(['brand']);
        });
    }
};
