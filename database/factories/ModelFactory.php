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

$factory->define(App\Drummer::class, function ($faker) {
	$genre = $faker->sentence(rand(1,1))	;
	$genre = substr($genre, 0, strlen($genre)-1);
	
    return [
    	'firstname' => $faker->firstname,
    	'middlename' => $faker->lastname, 
    	'lastname' => $faker->lastname, 
    	'genre' => $genre
    ];
});
