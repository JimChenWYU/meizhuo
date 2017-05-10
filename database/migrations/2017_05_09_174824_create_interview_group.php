<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('interview_group', function ($table)
        {
            $table->increments('id');
            $table->string('department', 10);
            $table->tinyInteger('number')->default('1');
            $table->tinyInteger('lock')->nullable()->default('0');
            $table->timestamps();

            $table->unique(['department', 'number']);
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
        Schema::drop('interview_group');
    }
}
