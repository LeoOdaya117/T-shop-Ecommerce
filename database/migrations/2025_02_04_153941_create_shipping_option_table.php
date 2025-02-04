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
        Schema::create('shipping_option', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Shipping method name (e.g., Standard, Express)
            $table->string('carrier')->nullable(); // Carrier (FedEx, UPS, etc.)
            $table->integer('min_days'); // Minimum estimated delivery time
            $table->integer('max_days'); // Maximum estimated delivery time
            $table->decimal('cost', 10, 2); // Shipping cost
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Minimum order amount for eligibility
            $table->boolean('tracking_available')->default(true); // Whether tracking is available
            $table->enum('status', ['active', 'inactive'])->default('active'); // Shipping option status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_option');
    }
};
