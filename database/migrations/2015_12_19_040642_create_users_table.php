<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password', 64);
            $table->string('nickname', 64);
            $table->text('address');
            $table->rememberToken();
            $table->string('confirm_code', 64);
            $table->timestamp('confirm_at')->nullable();
            $table->string('register_ip', 40);
            $table->timestamp('register_at')->nullable();
            $table->string('lastlogin_ip', 40);
            $table->timestamp('lastlogin_at')->nullable();
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
        Schema::drop('users');
    }
}
