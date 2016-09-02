<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShcoolsLessonsClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sch_name');
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gra_name');
            $table->timestamps();
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shi_name');
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sub_name');
            $table->timestamps();
        });

        Schema::create('school_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('scc_identifier');
            $table->unsignedInteger('scc_grade_id');
            $table->unsignedInteger('scc_shift_id');
            $table->timestamps();

            $table->foreign('scc_grade_id')->references('id')->on('grades');
            $table->foreign('scc_shift_id')->references('id')->on('shifts');

        });


        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('les_school_class_id');
            $table->unsignedInteger('les_subject_id');
            $table->dateTime('les_start');
            $table->dateTime('les_end');
            $table->timestamps();

            $table->foreign('les_school_class_id')->references('id')->on('school_classes');
            $table->foreign('les_subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'schools',
            'lessons',
            'school_classes',
            'grades',
            'shifts',
            'subjects',
        ];

        foreach ($tables as $value) {
            Schema::drop($value);
        }
    }
}
