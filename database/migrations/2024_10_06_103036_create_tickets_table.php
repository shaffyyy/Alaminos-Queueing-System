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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('window_id')->nullable()->constrained('windows')->onDelete('cascade');
            $table->enum('status', ['waiting', 'in-service', 'completed'])->default('waiting');
            $table->enum('verify', ['verified', 'unverified'])->default('unverified');
            $table->timestamp('verified_at')->nullable(); // Add verified_at column
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
