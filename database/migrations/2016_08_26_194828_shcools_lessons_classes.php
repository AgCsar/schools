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
        // Calendários escolares/anos letivos
        Schema::create('school_calendars', function(Blueprint $table){
            $table->increments('id');
            $table->integer('year');
            $table->date('start');
            $table->date('end');
            $table->timestamps();

        });        

        // Fases avaliativas (bimestres, semestres, etc.)
        Schema::create('evaluation_phases', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('start');
            $table->date('end');
            $table->unsignedInteger('school_calendar_id');
            $table->timestamps();

            $table->foreign('school_calendar_id')
                ->references('id')->on('school_calendars');
             
        });

        // Escolas
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // Ano estudantil (Jardim I, 1º Ano, etc.)
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // Turno da turma (matutino, vespertino, noturno)
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // Disciplina (matématica, português, física quântica)
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // Turmas (1º Ano A, Jardim I - A, Jardim I - B)
        Schema::create('school_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('shift_id');
            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('shift_id')->references('id')->on('shifts');

        });


        // Disciplinas existentes para um turma
        Schema::create('school_class_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('school_class_id');
            $table->unsignedInteger('subject_id');
            $table->timestamps();

            $table->foreign('school_class_id')
                ->references('id')->on('school_classes');
            
            $table->foreign('subject_id')
                ->references('id')->on('subjects');
        });

        // Aulas
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('school_class_id');
            $table->unsignedInteger('subject_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
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
            'lessons',
            'school_class_subjects',
            'school_classes',
            'subjects',
            'shifts',
            'grades',
            'schools',
            'evaluation_phases',
            'school_calendars',
        ];

        foreach ($tables as $value) {
            Schema::drop($value);
        }
    }
}
