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
        Schema::table('employees', function (Blueprint $blueprint) {
            // 1. Drop the foreign key constraint first
            $blueprint->dropForeign('employees_client_id_foreign');

            // 2. Optional: Drop the index if it wasn't dropped automatically
            $blueprint->dropIndex('employees_client_id_foreign');

            // 3. Finally, drop the column
            $blueprint->dropColumn('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $blueprint) {
            $blueprint->unsignedBigInteger('client_id')->nullable();
            
            // Re-add the foreign key if you roll back
            $blueprint->foreign('client_id')
                      ->references('id')
                      ->on('clients')
                      ->onDelete('cascade');
        });
    }
};
