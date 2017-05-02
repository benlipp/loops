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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Loops\Models\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(Loops\Models\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->domainName,
    ];
});

$factory->define(Loops\Models\Contact::class, function (Faker\Generator $faker) {
    return [
            'name'    => $faker->name,
            'company' => $faker->company,
            'email'   => $faker->email,
            'phone'   => $faker->phoneNumber,
    ];
});

$factory->define(Loops\Models\Loop::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->bs,
    ];
});

$factory->define(Loops\Models\Note::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->text(),
    ];
});
