<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('signers', function($table)
        {
            $table->increments('id');
            $table->string('student_id', 10);
            $table->string('name', 16);
            $table->string('major', 32)->nullable();
            $table->string('phone_num', 20)->nullable();
            $table->string('grade', 10)->nullable();
            $table->string('department', 10);
            $table->text('introduce')->nullable();
            $table->tinyInteger('has_apply')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();

            $table->unique(['student_id', 'department']);
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
        Schema::drop('signers');
    }
}
