<?php

use Faker\Generator as Faker;

$factory->define(App\ArticleTag::class, function (Faker $faker) {
    return [
        'article_id' => function () {
            return \App\Article::inRandomOrder()->first()->id;
        },
        'tag_id' => function () {
            return \App\Tag::inRandomOrder()->first()->id;
        },
    ];
});
