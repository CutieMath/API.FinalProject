<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Model\Bill;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Referral;
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


// User
$factory->define(User::class, function (Faker $faker) {
    static $password;
    
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('secret'), 
        'remember_token' => Str::random(10),
    ];
});



// Claim
$factory->define(Bill::class, function (Faker $faker) {
    
    return [

        'patient_id' => Patient::all()->random()->id,
        'item_numbers' => $faker->randomElement(['12', '123', '456']),
        'doctor_id' => Doctor::all()->random()->id, 
        'referral_id' => Referral::all()->random()->id,
        'date_of_service' => $faker->date($format = 'd/m/Y', $max = 'now'),
        'location_of_service' => $faker->address,
		'notes' => $faker -> paragraph(1),
		'status' => $faker -> emoji,      
    ];
});


// Doctor
$factory->define(Doctor::class, function(Faker $faker){

    return [
        'title' => $faker->title, 
        'first_name' => $faker->firstName, 
        'last_name' => $faker->lastName,
    ];

});


// Patient
$factory->define(Patient::class, function(Faker $faker){
    return [
        'title' => $faker->title, 
        'first_name' => $faker->firstName, 
        'last_name' => $faker->lastName,
    ];
});


// Referral
$factory->define(Referral::class, function(Faker $faker){

    return [
        'doctor_id' => Doctor::all()->random()->id,
        'length' => $faker->randomDigit().' months',
        'date' => $faker->date($format = 'd/m/Y', $max = 'now'),
    ];

});

