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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table
            $table->string('address_line_1'); // Primary address line
            $table->string('address_line_2')->nullable(); // Secondary address line (optional)
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('postal_code');
            $table->string('country');
            $table->boolean('is_primary')->default(false); // To mark primary address
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
