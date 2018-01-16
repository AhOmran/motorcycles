<?php
use App\Motorcycle;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Motorcycle::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'phone_number' => $faker->phoneNumber,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
