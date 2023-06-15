<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('terminal_id');
            $table->unsignedBigInteger('type_id'); // the type refers to the one of services in this table.
            $table->float('amount', 12);
            $table->float('charge', 12)->default(0.0);
            $table->float('total_amount', 12);
            $table->string('reference');
            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('info')->nullable();
            $table->string('power_token')->nullable();
            $table->enum('status', \App\Models\Transaction::ALL_STATUS)->default('PENDING');
            $table->enum('channel', ['POS', 'WEB', 'MOBILE', 'OTHERS'])->default('POS');
            $table->string('provider')->nullable();
            $table->boolean('wallet_debited')->nullable();
            $table->boolean('wallet_credited')->nullable();
            $table->string('version')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
