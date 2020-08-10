<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hobby;
use Faker\Generator as Faker;

$factory->define(Hobby::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->realText(30), //min 30 zeichen
        'beschreibung' => $faker->realText() //Standardwert - ca 200 Zeichen ...
    ];
});
