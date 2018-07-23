<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->sentence,
        'body' => $faker->paragraphs(3, true),
        'user_id' => function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'draft' => $faker->boolean
    ];
});
