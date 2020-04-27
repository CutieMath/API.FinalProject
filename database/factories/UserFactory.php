<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bill;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('secret'), 
        'remember_token' => Str::random(10),
    ];
});


$factory->define(Bill::class, function (Faker $faker) {
    return [
    	'title' => $faker->title,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'item_numbers' => $faker->randomElement(['12', '123', '456']),
        'attendant_doctor' => $faker->name,
        'referral' => $faker->name,
        'date_of_service' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'location_of_service' => $faker->address,
		'notes' => $faker -> paragraph(1),
		'status' => $faker -> emoji,      
    ];
});
