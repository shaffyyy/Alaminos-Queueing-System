<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('windows', function (Blueprint $table) {
        $table->foreignId('cashier_id')->nullable()->constrained('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('windows', function (Blueprint $table) {
        $table->dropForeign(['cashier_id']);
        $table->dropColumn('cashier_id');
    });
}

};
