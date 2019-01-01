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
            ],
            [
                'title' => 'Active Directory',
                'color' => '#26A69A',
                'slug'  => 'active-directory',
            ],
            [
                'title' => 'Windows 10',
                'color' => '#FF5722',
                'slug'  => 'windows-10',
            ],
            [
                'title' => 'iOS',
                'color' => '#AB47BC',
                'slug'  => 'ios',
            ],
            [
                'title' => 'HCSIS',
                'color' => '#448AFF',
                'slug'  => 'hcsis',
            ]
        ];

        foreach($skills as $skill)
        {
            \App\Skill::create($skill);
        }
    }
}
