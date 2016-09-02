<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$faker = Faker\Factory::create('pt_BR');

$factory->define(App\School::class, function () use ($factory, $faker) {
    return [
        'sch_name' => $faker->company.' school',
    ];
});


$factory->define(App\SchoolClass::class, function () use ($factory, $faker) {
    return [
        'scc_identifier' => $faker->randomLetter(),
        'scc_shift_id' => function(){
        	return factory(App\Shift::class)->create()->id;
        },
        'scc_grade_id' => function(){
        	return factory(App\Grade::class)->create()->id;
        },
    ];
});

$factory->define(App\Shift::class, function () use ($factory, $faker) {
    return [
        'shi_name' => $faker->randomElement(['matutino','noturno','vespertino']),
    ];
});

$factory->define(App\Grade::class, function () use ($factory, $faker) {
    return [
        'gra_name' => $faker->randomElement([
        		'Jardim I',
        		'Jardim II',
        		'1º Ano - fundamental I',
        		'2º Ano - fundamental I',
        		'3º Ano - fundamental I',
        		'4º Ano - fundamental I',
        		'5º Ano - fundamental II',
        		'6º Ano - fundamental II',
        		'7º Ano - fundamental II',
        		'8º Ano - fundamental II',
        		'9º Ano - fundamental II',
        		'1º Ano - Esino médio',
        		'2º Ano - Esino médio',
        		'3º Ano - Esino médio',
        	]),
    ];
});


$factory->define(App\Person::class, function () use ($factory, $faker) {
    
    $gender = $faker->randomElement(['female' ,'male']);

    return [
    	'peo_name' => $faker->name($gender), 
    	'peo_birthday' => $faker->dateTimeThisCentury->format('Y-m-d'), 
    	'peo_gender' => $gender, 
    	'peo_place_of_birth' => $faker->city, 
    	'peo_more' => $faker->text(),
    	];
});

$factory->define(App\Student::class, function ($faker) use ($factory) {
    
    return [
	    	'stu_person_id' => function(){
	    		return 	factory(App\Person::class)->create()->id;
	    	},
	    	'stu_school_class_id' => function(){
	    		return factory(App\SchoolClass::class)->create()->id;
	    	}
    	];
});


