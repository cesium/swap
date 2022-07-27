<?php

use App\Judite\Models\ShiftSchedule;

/*
|--------------------------------------------------------------------------
| Course Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(ShiftSchedule::class, function (Faker\Generator $faker) {
    
    return [
        'shift_id' => function () {
            return factory(Shift::class)->create()->id;
        },
        'weekday' => $faker->randomElement([1, 2, 3, 4, 5]),
        'start_time' => $faker->dateTime()->format('H:i:s'),
        'end_time' => $faker->dateTime()->format('H:i:s'),
        'location' => $faker->unique()->word(),
        'semester' => $faker->randomElement([1, 2]),
    ];
});
