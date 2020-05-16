<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'book_title' => $faker->word,
        'book_description' => $faker->sentence,
        'author_name' => $faker->word,
        'cat_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
        'quantity' => $faker->randomFloat(2, 0, 10000),
        'rate' => $faker->randomFloat(2, 0, 10000),
        'book_img' => $faker->image('public/storage/images', 640, 480, null, false),
    ];
});
