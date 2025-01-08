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
        Schema::create("orders",function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->text(column: 'product_id');
            $table->text(column: 'quantity');
            $table->float('total_price');
            $table->string(column: "fname");
            $table->string(column: "lname");
            $table->string(column: "email")->nullable();
            $table->string("address");
            $table->string("address2")->nullable();
            $table->string("city");
            $table->string("state");
            $table->string("country");
            $table->string("pincode");
            $table->string("phone");
            $table->string("payment_id")->nullable();
            $table->string("status")->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
