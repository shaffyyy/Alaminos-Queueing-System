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
        Schema::table('windows', function (Blueprint $table) {
            $table->boolean('isPriority')->default(0)->after('status'); // Add isPriority column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('windows', function (Blueprint $table) {
            $table->dropColumn('isPriority'); // Drop the column on rollback
        });
    }
};
