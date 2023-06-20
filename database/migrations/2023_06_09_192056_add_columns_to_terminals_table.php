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
        Schema::table('terminals', function (Blueprint $table) {
            $table->string('admin_pin')->default('0000');
            $table->string('pin')->default('0000');
            $table->integer('wrong_pin_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('terminals', function (Blueprint $table) {
            $table->dropColumn(['admin_pin', 'pin', 'wrong_pin_count']);
        });
    }
};
