<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttendanceRecordsAndStudentGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Registros de presença
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('student_id');
            // 0 Faltou a aula
            // 1 Estava presente
            $table->tinyInteger('presence');
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('student_id')->references('id')->on('students');

            $table->unique(['lesson_id', 'student_id']);
        });

        // Avaliações
        Schema::create('assessments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        // Notas dos alunos
        Schema::create('student_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('grade');
            $table->unsignedInteger('assessment_id');
            $table->unsignedInteger('student_id');
            $table->bigInteger('school_class_subject_id')->unsigned();
            $table->timestamps();

            $table->foreign('school_class_subject_id')
                ->references('id')->on('school_class_subjects');

            $table->foreign('assessment_id')
                ->references('id')->on('assessments');
            
            $table->foreign('student_id')
                ->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendance_records');
        Schema::drop('student_grades');
        Schema::drop('assessments');
    }
}
