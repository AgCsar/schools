<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Students extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('peo_name');
            $table->date('peo_birthday')->nulllable();
            $table->string('peo_gender');
            $table->string('peo_place_of_birth');
            $table->string('peo_more');
            $table->timestamps();
        });


        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stu_person_id');
            $table->unsignedInteger('stu_school_class_id');
            $table->timestamps();

            $table->foreign('stu_school_class_id')->references('id')->on('school_classes');
            $table->foreign('stu_person_id')->references('id')->on('people');

        });

        Schema::create('student_responsible', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('str_student_id');
            $table->unsignedInteger('str_person_id');

            $table->foreign('str_student_id')->references('id')->on('students');
            $table->foreign('str_person_id')->references('id')->on('people');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_responsible');
        Schema::drop('students');
        Schema::drop('people');
    }
}
