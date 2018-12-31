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
        
        $items = [
            [
                'title' => 'PHP Control Structures',
                'type'  => 'Article',
                'slug'  => 'php-control-structures',
            ],
            [
                'title' => 'PHP Control Structures Quiz',
                'type'  => 'Quiz',
                'slug'  => 'php-control-structures-quiz',
            ],
            [
                'title' => 'HTML Tags',
                'type'  => 'Article',
                'slug'  => 'html-tags',
            ],
            [
                'title' => 'HTML Tags Quiz',
                'type'  => 'Quiz',
                'slug'  => 'html-tags-quiz',
            ],
            [
                'title' => 'JavaScript Termination Points',
                'type'  => 'Article',
                'slug'  => 'js-termination-points',
            ],
            [
                'title' => 'JavaScript Termination Points Quiz',
                'type'  => 'Quiz',
                'slug'  => 'js-termination-points-quiz',
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Article',
                'slug'  => 'css-selectors',
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Quiz',
                'slug'  => 'css-selectors-quiz',
            ]
        ];

        foreach($items as $record)
        {
            \App\Lecture::create($record);
        }
    }
}
