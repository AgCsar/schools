<?php

namespace Tests;

use App\SchoolCalendar;
use App\SchoolClassStudent;
use App\Student;
use App\Subject;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    /**
     * @covers StudentControllerTest::index
     *
     * @return void
     */
    public function testIndex()
    {
    	$student = factory(\App\Student::class)->create();

    	$this->get('api/students',$this->getAutHeader())
    		->assertResponseStatus(200);
    }

    /**
     * @todo  Implementar teste unitário para para App\Student
     * 
     * @covers StudentController::annualSummary
     *
     * @return void
     */
    public function testAnnualSummary()
    {

        Artisan::call('migrate:refresh',[
                '--seed' => true
            ]);

        Artisan::call('db:seed',[
                '--class' => 'SchoolCalendar2016'
            ]);

        // Pega o ultimo estudante que foi criado pelo seeder SchoolCalendar2016
        $student = Student::
            orderBy('id', 'desc')
            ->first();

         $schoolCalendar = SchoolCalendar::
            orderBy('id', 'desc')
            ->first();

        $average_structure = [
            'id', 'name', 'average_calculation', 'average',
            'student_grades' => ['*' => [
                    'id', 
                    'grade', 
                    'subject_id',
                    'assessment' => ['name', 'id'],
                ]

            ]
        ];

        $this->get("api/students/$student->id/annual-summary".
            "?school_calendar_id=$schoolCalendar->id",
            $this->getAutHeader())
            ->seeJsonStructure([
                "absences" => ['total'],
                "best_average" => $average_structure,
                "low_average" => $average_structure
            ]);
        
    } 

    /**
     * @covers StudentControllerTest::annualReport
     * 
     * @return void
     */
    public function testAnnualReport()
    {
        Artisan::call('migrate:refresh',[
                '--seed' => true
            ]);

        Artisan::call('db:seed',[
                '--class' => 'SchoolCalendar2016'
            ]);
        
        $this->get('api/students/1/annual-report'.
            "?school_calendar_id=1",
            $this->getAutHeader())
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'averages' => ['*' => 
                    ['id', // Fase do ano
                    'name', 
                    'start', 
                    'end', 
                    'average_calculation', // Formula do calculo de média
                    'subject_average' => ['*' =>[
                        'name',  // Disciplina 
                        'average_calculation', // Calculo da média
                        'average',  // Média do aluno para disciplina no ano
                        'student_grades' => ['*' => [ // Notas do aluno para disciplina
                                'grade',
                                'student_id',
                                'assessment' => ['name'] // Dado
                                ],
                            ] 
                        ]] 
                    ]
                ],
                'absences' => ['*' => [ // Total de faltas do aluno no ano por 
                                        // disciplina e fase
                    'absences', 
                    'school_calendar_phase_id',
                    'subject_id',
                    ] 

                ],
                // Lista de disciplinas cursadas no ano
                'subjects' => ['*' => ['id', 'name']
                ],
                ]);
    }

}
