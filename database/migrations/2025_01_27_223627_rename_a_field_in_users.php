<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
           // Add the new column
           $table->string('firstname')->nullable()->after('id');
           $table->string('lastname')->nullable()->after('firstname');

         
           // Drop the old column
           $table->dropColumn('name');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             // Add the old column back
             $table->string('name')->nullable();

             
 
             // Drop the new column
             $table->dropColumn('firstname');
             // Drop the new column
             $table->dropColumn('lastname');


        });
    }
};
