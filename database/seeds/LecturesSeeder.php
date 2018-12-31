<?php

use Illuminate\Database\Seeder;

class LecturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        auth()->loginUsingId(5);
        $faker = Faker\Factory::create();
        
        $items = [
            [
                'title' => 'PHP Control Structures',
                'type'  => 'Article',
                'slug'  => 'php-control-structures',
                'body' => $faker->text(5000)
            ],
            [
                'title' => 'PHP Control Structures Quiz',
                'type'  => 'Quiz',
                'slug'  => 'php-control-structures-quiz',
                'body' => $faker->text(500)
            ],
            [
                'title' => 'HTML Tags',
                'type'  => 'Article',
                'slug'  => 'html-tags',
                'body' => $faker->text(5000)
            ],
            [
                'title' => 'HTML Tags Quiz',
                'type'  => 'Quiz',
                'slug'  => 'html-tags-quiz',
                'body' => $faker->text(500)
            ],
            [
                'title' => 'JavaScript Termination Points',
                'type'  => 'Article',
                'slug'  => 'js-termination-points',
                'body' => $faker->text(5000)
            ],
            [
                'title' => 'JavaScript Termination Points Quiz',
                'type'  => 'Quiz',
                'slug'  => 'js-termination-points-quiz',
                'body' => $faker->text(500)
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Article',
                'slug'  => 'css-selectors',
                'body' => $faker->text(5000)
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Quiz',
                'slug'  => 'css-selectors-quiz',
                'body' => $faker->text(500)
            ]
        ];

        foreach($items as $record)
        {
            \App\Lecture::create($record);
        }
    }
}
