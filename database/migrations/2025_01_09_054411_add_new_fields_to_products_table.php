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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique()->after('quantity');
            }
            $table->string('category')->nullable()->after('sku');
            $table->string('brand')->nullable()->after('category');
            $table->string('size')->nullable()->after('brand');
            $table->string('color')->nullable()->after('size');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('color');
            $table->float('discount')->default(0)->after('status');
            $table->integer('stock')->default(0)->after('discount');
            $table->float('weight')->nullable()->after('stock');
            $table->string('dimensions')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropUnique(['sku']);
                $table->dropColumn('sku');
            }
            $table->dropColumn('category');
            $table->dropColumn('brand');
            $table->dropColumn('size');
            $table->dropColumn('color');
            $table->dropColumn('status');
            $table->dropColumn('discount');
            $table->dropColumn('stock');
            $table->dropColumn('weight');
            $table->dropColumn('dimensions');
        });
    }
};