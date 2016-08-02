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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

/**
 * Modal factory for Image model
 * default profile id is 1
 */
$factory->define(App\Image::class, function (Faker\Generator $faker) {
    return [
        'link' => $faker->url,
        'thumb' => $faker->imageUrl($width = 150, $height = 150),
        'full' => $faker->imageUrl($width = 640, $height = 640),
        'caption_text' => $faker->realText($maxNbChars = 100),
        'title' => $faker->realText($maxNbChars = 255),
        'alt' => $faker->realText($maxNbChars = 500),
        'created_time' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'),
        'image_id' => '1111111111111111111_1111111111',
        'profile_id' => '1',
        'category_id' => '1'
    ];
});

/**
 * Modal factory for Instagram Profile
 */
$factory->define(App\InstagramProfile::class, function (Faker\Generator $faker) {
   return [
       'name' => 'test',
       'profile_id' => 1,
   ];
});

/**
 * Modal factory for Category
 */
$factory->define(App\Category::class, function (Faker\Generator $faker) {
   return [
       'name' => 'test'
   ];
});

