<?php

use Illuminate\Database\Seeder;

class LessonsSeeder extends Seeder
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
                'title' => 'PHP Syntax',
                'slug'  => 'php-syntax',
            ],
            [
                'title' => 'HTML Syntax',
                'slug'  => 'html-syntax',
            ],
            [
                'title' => 'JavaScript Syntax',
                'slug'  => 'js-syntax',
            ],
            [
                'title' => 'CSS Syntax',
                'slug'  => 'css-syntax',
            ]
        ];

        foreach($items as $record)
        {
            \App\Lesson::create($record);
        }
    }
}
