<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Manager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manager', function($table)
        {
            $table->increments('id');
            $table->string('account', 16);
            $table->string('password', 32);
            $table->rememberToken();
            $table->integer('competence')->default(1);
            $table->dateTime('last_login_time');
            $table->string('last_login_ip', 16);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('manager');
    }
}
