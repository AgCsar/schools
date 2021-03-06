<?php

use App\Assessment;
use App\Lesson;
use App\Occurence;
use App\SchoolCalendar;
use App\SchoolCalendarPhase;
use App\SchoolClass;
use App\SchoolClassStudent;
use App\SchoolClassSubject;
use App\Student;
use App\StudentGrade;
use App\StudentResponsible;
use App\Subject;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * @author Kévio Castro keviocastro@gmail.com
 */
class SchoolCalendar2016 extends Seeder
{
    /**
     * Run the database seeds.
     * 
     *
     * @return void
     */
    public function run()
    {   
        self::create();
    }

    /**
     * Cria um calendario para 2016
     * Com uma turma
     * Aulas durante todo o ano para essa turma com 5 disciplinas, onde:
     *     O professor 1 ministra aulas para as disciplinas 1 e 2.
     *     As disciplinas 3,4,5 tem são ministradas pelos professores 2,3,4 respectivamente. 
     * Cria Alunos para a turma
     * Cria Responsaveis pelos alunos
     * Cria Registros de notas dos alunos durante o ano
     * Cria Registros de falta durante o ano
     *
     *
     *  Aulas: 240 aulas criadas para cada disciplina.
     *         Todos os dias, exceto sabado e domingo
     *  
     *  NOTAS:
     *      
     *       Para o primeiro aluno criado (id = 1), e
     *       1º disciplina criada (id = 1), com nome Matématica, tem as notas: 
     *       
     *       Nota 1.1 = 10 
     *       Nota 1.2 = 9.2 
     *       Nota 2.1 = 8.5
     *       Nota 2.2 = 10 
     *       Nota 3.1 = 9.5
     *       Nota 3.2 = 9.0
     *       Nota 4.1 = 10 
     *       Nota 4.2 = 9.6
     *       
     *       Média = (10+9.2)/2 = 9.6 +      // 1 Bimestre. 
     *               (8.5+10)/2 = 9.3 +     // 2 Bim.
     *               (9.5+9.0)/2 = 9.3 +    // 3 Bim.
     *               (10+9.6)/2 = 9.8        // 4 Bim.
     *               
     *       A média anual é calculada por: 
     *       ( (1 Bim + 2 Bim) * 0.4 + (3 Bim + 4 Bim) * 0.6 ) / 2 = MÉDIA NO ANO
     *       
     *       1 Semestre = (9.6 + 9.25)*0.4 = 7.54
     *       2 Semestre = (9.25 + 9.8)*0.6 = 11.43
     *       
     *       ( 7.54 + 11.43 ) /2  = 9.48
     *       
     *      2º disciplina criada é a menor média do ano = 0.2
     *  
     *  FALTAS:
     *  
     * Para o 1º aluno criado (id = 1):
     * 
     *    1º Bimestre = 4
     *    2º Bimestre = 3
     *    3º Bimestre = 6
     *    4º Bimestre = 2
     *    Total no ano: 15
     *
     *
     * Pra o 2º aluno criado (id = 2), e 1º disciplina criada (id = 1), 
     * com nome Matématica, tem as notas:
     *     
     *     Nota 1.1 = 7.2 
     *     Nota 1.2 = 9.6
     *     Nota 2.1 =           (sem nota)
     *     Nota 2.2 = 8.5 
     *     Nota 3.1 =           (sem nota)
     *     Nota 3.2 =           (sem nota)
     *     Nota 4.1 = 9.2        
     *     Nota 4.2 = 8.6
     *
     *     1º Bimestre (7.2+9.6)/2 = 8.4
     *     2º Bimestre (SemNota+8.5) = sem média do bimestre
     *     3º Bimestre (SemNota+SemNota) = sem média do bimestre
     *     4º Bimestre (9.2+8.6)/2 = 8.9
     * 
     * @return array
     */
    public static function create()
    {
        // Calendario escolar com 4 bimesres
        // 3 notas por bimestre para compor a nota do bimestre.
        dump('Criando calendário escolar e avaliações...');
        $schoolCalendar = factory(SchoolCalendar::class)->create([
            'year' => '2016',
            'start' => '2016-01-20',
            'end' => '2016-12-16',
            'average_formula' => 
                '( ({1º Bimestre} + {2º Bimestre})*0.4 + ({3º Bimestre} + {4º Bimestre})*0.6 )/2'
        ]);
        $schoolCalendarPhase1 = factory(SchoolCalendarPhase::class)->create([
            'school_calendar_id' => $schoolCalendar->id,
            'name' => '1º Bimestre',
            'start' => '2016-01-16',
            'end' => '2016-04-15',
            'average_formula' => '({Nota 1.1} + {Nota 1.2})/2'
        ]);

        $assessments[] = factory(App\Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase1->id,
                'name' => 'Nota 1.1', 
            ])->toArray();
        $assessments[] = factory(App\Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase1->id,
                'name' => 'Nota 1.2', 
            ])->toArray(); 
            
        Assessment::insert($assessments);

        $schoolCalendarPhase2 = factory(SchoolCalendarPhase::class)->create([
            'school_calendar_id' => $schoolCalendar->id,
            'name' => '2º Bimestre',
            'start' => '2016-04-16',
            'end' => '2016-06-30',
            'average_formula' => '({Nota 2.1} + {Nota 2.2})/2'
        ]);

        $assessments = [
            factory(Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase2->id,
                'name' => 'Nota 2.1', 
            ])->toArray(),
            factory(Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase2->id,
                'name' => 'Nota 2.2', 
            ])->toArray()
        ];
        Assessment::insert($assessments);

        $schoolCalendarPhase3 = factory(SchoolCalendarPhase::class)->create([
            'school_calendar_id' => $schoolCalendar->id,
            'name' => '3º Bimestre',
            'start' => '2016-08-01',
            'end' => '2016-09-30',
            'average_formula' => '({Nota 3.1} + {Nota 3.2})/2'
        ]);
        $assessments = [
            factory(Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase3->id,
                'name' => 'Nota 3.1', 
            ])->toArray(),
            factory(Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase3->id,
                'name' => 'Nota 3.2', 
            ])->toArray()
        ];
        Assessment::insert($assessments);

        $schoolCalendarPhase4 = factory(SchoolCalendarPhase::class)->create([
            'school_calendar_id' => $schoolCalendar->id,
            'name' => '4º Bimestre',
            'start' => '2016-10-01',
            'end' => '2016-12-16',
            'average_formula' => '({Nota 4.1} + {Nota 4.2})/2'
        ]);
        $assessments = [
            factory(App\Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase4->id,
                'name' => 'Nota 4.1', 
            ])->toArray(),
            factory(App\Assessment::class)->make([
                'school_calendar_phase_id' => $schoolCalendarPhase4->id,
                'name' => 'Nota 4.2', 
            ])->toArray()
        ];
        Assessment::insert($assessments);

        // 1 Turma
        // 20 Alunos
        // 1 Responsável para cada aluno
        // 4 Registros de ocorrencia para cada aluno
        dump('Criando turmas e alunos...');
        $schoolClass = factory(SchoolClass::class)->create([
                'school_calendar_id' => $schoolCalendar->id
            ]);
        $students = factory(Student::class, 20)->create()
            ->each(function($student) use ($schoolClass){
                factory(StudentResponsible::class)->create([
                        'student_id' => $student->id 
                    ]);
                factory(SchoolClassStudent::class)->create([
                        'student_id' => $student->id,
                        'school_class_id' => $schoolClass->id
                    ]);
                if (rand(0,1)) {
                    factory(Occurence::class, 4)->create([
                            'about_person_id' => $student->id
                        ]);
                }
            });

        // Estudante que terão dados de faltas e notas
        // pré-definidos para ser utilizados em testes 
        $studentFixedData = $students[0];
        $studentFixedData2 = $students[1];


        $start = Carbon::createFromFormat('Y-m-d', $schoolCalendarPhase1->start);
        $end = Carbon::createFromFormat('Y-m-d', $schoolCalendarPhase4->end);

        // Cria aulas para 5 disciplinas
        dump('Criando aulas do calendário escolar...');
        $subjects = [];

        $subject = factory(Subject::class)->create([
                'name' => 'Matématica'
            ]);
        $teacher1 = factory(Teacher::class)->create();
        $subjectFixedData = $subject;
        array_push($subjects, $subject);
        LessonsFactory::createBetweenTwoDates(
            $start, 
            $end, 
            7,
            $schoolClass,
            $subject,
            $teacher1);


        $subject = factory(Subject::class)->create();
        $subjectFixedData2 = $subject;
        array_push($subjects, $subject);
        LessonsFactory::createBetweenTwoDates(
            $start, 
            $end, 
            8,
            $schoolClass,
            $subject,
            $teacher1);

        $teacher2 = factory(Teacher::class)->create();
        $subject = factory(Subject::class)->create();
        array_push($subjects, $subject);
        LessonsFactory::createBetweenTwoDates(
            $start, 
            $end, 
            9,
            $schoolClass,
            $subject,
            $teacher2);

        $teacher3 = factory(Teacher::class)->create();
        $subject = factory(Subject::class)->create();
        array_push($subjects, $subject);
        LessonsFactory::createBetweenTwoDates(
            $start, 
            $end, 
            10,
            $schoolClass,
            $subject,
            $teacher3);

        $teacher4 = factory(Teacher::class)->create();
        $subject = factory(Subject::class)->create();
        array_push($subjects, $subject);
        LessonsFactory::createBetweenTwoDates(
            $start, 
            $end, 
            11,
            $schoolClass,
            $subject,
            $teacher4);

        // Definindo disciplinas da turma
        $schoolClassSubjects = [];
        foreach ($subjects as $key => $subject) {
            array_push($schoolClassSubjects, [
                    'school_class_id' => $schoolClass->id,
                    'subject_id' => $subject->id
                ]); 
        }

        SchoolClassSubject::insert($schoolClassSubjects);

        // 1º Bimeste
        dump('Registrando presenças e notas para o 1º Bimestre...');
        $assessments = $schoolCalendarPhase1->assessments()
            ->orderBy('id')->get();
        
        $fixedDataSubjects = [
                // 1º Aluno
                [
                    'subject_id' =>  $subjectFixedData->id,
                    'grade' => 10,
                    'student_id' => $studentFixedData->id,
                    'assessment_id' => $assessments[0]->id
                ],
                [
                    'subject_id' => $subjectFixedData->id,
                    'grade' => 9.2,
                    'student_id' => $studentFixedData->id,
                    'assessment_id' => $assessments[1]->id
                ],
                [
                    'subject_id' => $subjectFixedData2->id,
                    'grade' => 0.2,
                    'student_id' => $studentFixedData->id,
                ],
                // 2º Aluno
                [
                    'subject_id' =>  $subjectFixedData->id,
                    'grade' => 7.2,
                    'student_id' => $studentFixedData2->id,
                    'assessment_id' => $assessments[0]->id
                ],
                [
                    'subject_id' => $subjectFixedData->id,
                    'grade' => 9.6,
                    'student_id' => $studentFixedData2->id,
                    'assessment_id' => $assessments[1]->id
                ],
            ];
        AttendanceRecordsFactory::create($schoolCalendarPhase1, 4, $studentFixedData->id);
        StudentGradesFactory::create($schoolCalendarPhase1, 
            $schoolClass, $subjects, $fixedDataSubjects);

        // 2º Bimestre
        dump('Registrando presenças e notas para o 2º Bimestre...');
        $assessments = $schoolCalendarPhase2->assessments()
            ->orderBy('id')->get();
        // 1º Aluno 
        $fixedDataSubjects[0]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[0]['grade'] = 8.5;

        $fixedDataSubjects[1]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[1]['grade'] = 10;
        // 2º Aluno 
        $fixedDataSubjects[3]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[3]['grade'] = 'do-not-create';

        $fixedDataSubjects[4]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[4]['grade'] = 8.5;
        

        AttendanceRecordsFactory::create($schoolCalendarPhase2, 3, $studentFixedData->id);
        $assessments_phase_2 = $schoolCalendarPhase2->assessments;
        StudentGradesFactory::create($schoolCalendarPhase2, $schoolClass, 
            $subjects, $fixedDataSubjects);

        // 3º Bimestre
        dump('Registrando presenças e notas para o 3º Bimestre...');
        $assessments = $schoolCalendarPhase3->assessments()
            ->orderBy('id')->get();
        // 1º Aluno
        $fixedDataSubjects[0]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[0]['grade'] = 9.5;

        $fixedDataSubjects[1]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[1]['grade'] = 9.0;
        // 2º Aluno 
        $fixedDataSubjects[3]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[3]['grade'] = 'do-not-create';

        $fixedDataSubjects[4]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[4]['grade'] = 'do-not-create';
        
        AttendanceRecordsFactory::create($schoolCalendarPhase3, 6, $studentFixedData->id);
        StudentGradesFactory::create($schoolCalendarPhase3, $schoolClass, 
            $subjects, $fixedDataSubjects);

        // 4º Bimestre
        dump('Registrando presenças e notas para o 4º Bimestre...');
        $assessments = $schoolCalendarPhase4->assessments()
            ->orderBy('id')->get();
        //1º Aluno
        $fixedDataSubjects[0]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[0]['grade'] = 10;

        $fixedDataSubjects[1]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[1]['grade'] = 9.6;
        // 2º Aluno 
        $fixedDataSubjects[3]['assessment_id'] = $assessments[0]->id;
        $fixedDataSubjects[3]['grade'] = 9.2;

        $fixedDataSubjects[4]['assessment_id'] = $assessments[1]->id;
        $fixedDataSubjects[4]['grade'] = 8.6;

        AttendanceRecordsFactory::create($schoolCalendarPhase4, 2, $studentFixedData->id);
        $assessments_phase_4 = $schoolCalendarPhase4->assessments;
        StudentGradesFactory::create($schoolCalendarPhase4, $schoolClass, 
            $subjects, $fixedDataSubjects);
    }
}
