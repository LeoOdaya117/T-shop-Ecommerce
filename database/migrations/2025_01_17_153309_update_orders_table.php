<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Directly use SQL to rename the column for MySQL compatibility
        DB::statement('ALTER TABLE orders CHANGE COLUMN status payment_status VARCHAR(255) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert the 'payment_status' field back to 'status'
            DB::statement('ALTER TABLE orders CHANGE COLUMN payment_status status VARCHAR(255) NOT NULL');

          
        });
    }
};
