# Group Students

Ações relacionadas a informações dos alunos: cadastrais, indicadores de desempenho
e relatórios como "Boletim anual do aluno" e "Histórico escolar".

## Annual Report [/students/{student_id}/annual-report{?school_calendar_id}]

### Annual Report [GET]

+ Parameters
    + school_calendar_id: 1 (required, number) - ID do ano letivo

+ Request 
    + Headers
    
            authorization: <!-- include(Token.md) -->
            
+ Response 200 (application/json)

    + Attributes (object)
        + report_by_subjects (array) - Médias e faltas por disciplina no ano letivo
            + (object)
                + include (Subject)
                + average_calculation: `((9.6 + 9.3)*0.4 + (9.3 + 9.8)*0.6)/2` (string) - `Calculo de média da disciplina`
                + average_formula: `( ({1º Bimestre} + {2º Bimestre})*0.4 + ({3º Bimestre} + {4º Bimestre})*0.6 )/2` (string) - `Formula utilizada para calcular a média anual da disciplina`
                + average_year: 8.2 (number) - `Média do aluno para disciplina no ano letivo`
                + absences: 10 (number) - `Total de faltas do aluno para disciplina no ano letivo`
                + school_calendar_phases (array)
                    + (object)
                        + id: 1 (number) - `ID da fase do ano`
                        + average: 7.2 (number) - `Média do aluno no para disciplina na fase do ano`
                        + average_calculation: `(6.5 + 5.7)/2` (string) - `Calculo da média da disciplina na fase do ano` 
                        + average_f ormula: `({Nota 1.1} + {Nota 1.2})/2` (string) - `Formula utilizada para  calcular a média da disciplina na fase do ano`    
                        + absences: 2 (number) - `Total de faltas do aluno para disciplina na fase do ano`
                        + student_grades (array[object])
                            + (object)
                                + include (StudentGrade)
        + school_calendar_phases (array) - Fases avaliativas do ano letivo
            + (SchoolCalendarPhase)


## Annual Student Summary [/students/{student_id}/annual-summary{?school_calendar_id}]

### View a annual student summary [GET]

+ Parameters
    + school_calendar_id: 1 (number, required) - `ID do ano letivo`

+ Request 
    + Headers
    
            authorization: <!-- include(Token.md) -->
            
+ Response 200 (application/json)

    + Attributes (object)
        + absences (object)
            + total: 22 (number) - Total de faltas do aluno no ano letivo
        + best_average (object) - Melhor média do aluno no ano
            + include (Subject)
            + average: 9.5 (number) - Média
            + average_calculation: `(7.8 + 8.5)/2` (string) - Calculo da média
            + student_grades (array) - Notas do aluno que compõem a média 
                + (object)
                    + include (StudentGrade)
                    + assessment (Assessment) 
        + low_average (object) - Pior média do aluno no ano
            + include (Subject)
            + average (number)
            + average_calculation (string)
            + student_grades (array) 
                + (object)
                    + include (StudentGrade)
                    + assessment (Assessment) 