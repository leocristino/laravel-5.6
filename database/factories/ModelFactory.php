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


$factory->define(App\Models\PedagogicoDestino::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name(),
        'end_cep' => $faker->randomNumber(5).$faker->randomNumber(3),
        'end_logradoro' => $faker->streetName,
        'end_numero' =>$faker->randomNumber(3),
        'end_complemento' => $faker->realText(10),
        'end_bairro' => $faker->name,
        'end_uf' => 'SP',
        'end_cidade' => $faker->city,
        'end_id_cidade' => $faker->randomNumber(3),
        'site' => 'http://'.$faker->domainName,

        'nome_contato' => $faker->name(),
        'telefone' => '('.$faker->randomNumber(2).') '.$faker->numberBetween(1000, 99999).'-'.$faker->randomNumber(4),
        'email' => $faker->email,
        'obs' => '',
        //'latitude' => $faker->latitude,
        //'longitude' => $faker->longitude,
    ];
});