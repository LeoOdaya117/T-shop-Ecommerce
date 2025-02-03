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
    public function up(): void
    {
        // First, drop the foreign keys that reference user_id and product_id.
        Schema::table('wishlist', function (Blueprint $table) {
            // Drop foreign keys by column name (Laravel will infer the key names)
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });

        // Disable foreign key checks to drop the unique index.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Now drop the unique index.
        Schema::table('wishlist', function (Blueprint $table) {
            // Use the index name directly
            $table->dropUnique('wishlist_user_id_product_id_unique');
        });

        // Re-enable foreign key checks.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Finally, add the new unique constraint and re-add the foreign keys.
        Schema::table('wishlist', function (Blueprint $table) {
            // New unique constraint including variant_id.
            $table->unique(['user_id', 'product_id', 'variant_id']);
            
            // Re-add foreign key constraints.
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the process: drop the new unique constraint and foreign keys,
        // then re-add the old unique constraint and foreign keys.
        Schema::table('wishlist', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id', 'variant_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('wishlist', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id']);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};
