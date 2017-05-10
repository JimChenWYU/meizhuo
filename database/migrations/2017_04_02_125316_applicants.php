<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Applicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('applicants', function($table)
        {
            $table->increments('id');
            $table->string('student_id', 10);
            $table->string('name', 16);
            $table->string('major', 32);
            $table->string('phone_num', 20);
            $table->string('grade', 10);
            $table->string('department', 10);
            $table->text('introduce')->default('');
            $table->timestamps();

            $table->index('student_id');
            $table->index('name');
            $table->index('department');
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
        Schema::drop('applicants');
    }
}
