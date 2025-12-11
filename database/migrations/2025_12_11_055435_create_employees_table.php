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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                    ->constrained('clients')   // references id on clients
                    ->onDelete('cascade');     // delete employees if client is deleted

            $table->foreignId('channel_id')
                    ->constrained('channels')  // references id on channels
                    ->onDelete('cascade');     // delete employees if channel is deleted

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email', 250)->unique();
            $table->string('phone', 15)->unique();
            $table->string('occupation');
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('online');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
