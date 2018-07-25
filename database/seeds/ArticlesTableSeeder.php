<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Article::class)->times(100)->create();

        factory(\App\ArticleTag::class)->times(200)->create();
    }
}
