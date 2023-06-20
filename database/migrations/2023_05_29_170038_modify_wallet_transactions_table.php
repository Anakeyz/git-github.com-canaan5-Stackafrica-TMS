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
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->enum('action', \App\Enums\Action::values())->after('status');
            $table->enum('type', \App\Models\WalletTransaction::TYPES)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->string('reason');
            $table->unsignedInteger('user_id');
            $table->string('type');
        });
    }
};
