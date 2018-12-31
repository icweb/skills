<?php

use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        auth()->loginUsingId(5);

        $skills = [
            [
                'title' => 'PHP',
                'color' => '#448AFF',
                'slug'  => 'php',
            ],
            [
                'title' => 'HTML',
                'color' => '#689F38',
                'slug'  => 'html',
            ],
            [
                'title' => 'JavaScript',
                'color' => '#9C27B0',
                'slug'  => 'javascript',
            ],
            [
                'title' => 'CSS',
                'color' => '#D32F2F',
                'slug'  => 'css',
            ]
        ];

        foreach($skills as $skill)
        {
            \App\Skill::create($skill);
        }
    }
}
