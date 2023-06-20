<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('level_id')->nullable();
            $table->unsignedInteger('super_agent_id')->nullable();
            $table->string('first_name');
            $table->string('other_names');
            $table->string('email')->unique();
            $table->string('phone', 15)->unique();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('dob')->nullable();
            $table->string('state');
            $table->string('country')->default('Nigeria');
            $table->mediumText('address');
            $table->enum('level', [1, 2, 3, 4])->default(1);
            $table->enum('status', \App\Models\User::ALL_STATUS)->default('INACTIVE');
            $table->string('avatar')->nullable();
            $table->string('bvn', 11)->unique()->nullable();
            $table->string('nin', 15)->unique()->nullable();
            $table->timestamp('password_change_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
