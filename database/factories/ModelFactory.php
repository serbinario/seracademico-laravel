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

/*$factory->define(Seracademico\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});*/

# Factory para criação de pessoas faker
$factory->define(Seracademico\Entities\Pessoa::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'nome_pai' => $faker->name,
        'nome_mae' => $faker->name,
        'cpf' => $faker->numerify('###########'),
        'identidade' => $faker->numerify('#######'),
        'data_nasciemento' => $faker->dateTime
    ];
});