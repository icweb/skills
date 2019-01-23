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
                'body' => $faker->text(5000),
                'completion_time' => 300
            ],
            [
                'title' => 'PHP Control Structures Quiz',
                'type'  => 'Quiz',
                'slug'  => 'php-control-structures-quiz',
                'body' => $faker->text(500),
                'completion_time' => 300,
                'quiz_required_score' => 85
            ],
            [
                'title' => 'HTML Tags',
                'type'  => 'Article',
                'slug'  => 'html-tags',
                'body' => $faker->text(5000),
                'completion_time' => 300
            ],
            [
                'title' => 'HTML Tags Quiz',
                'type'  => 'Quiz',
                'slug'  => 'html-tags-quiz',
                'body' => $faker->text(500),
                'completion_time' => 300,
                'quiz_required_score' => 85
            ],
            [
                'title' => 'JavaScript Termination Points',
                'type'  => 'Article',
                'slug'  => 'js-termination-points',
                'body' => $faker->text(5000),
                'completion_time' => 300
            ],
            [
                'title' => 'JavaScript Termination Points Quiz',
                'type'  => 'Quiz',
                'slug'  => 'js-termination-points-quiz',
                'body' => $faker->text(500),
                'completion_time' => 300,
                'quiz_required_score' => 85
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Article',
                'slug'  => 'css-selectors',
                'body' => $faker->text(5000),
                'completion_time' => 300
            ],
            [
                'title' => 'CSS Selectors',
                'type'  => 'Quiz',
                'slug'  => 'css-selectors-quiz',
                'body' => $faker->text(500),
                'completion_time' => 300,
                'quiz_required_score' => 85
            ],
            [
                'title' => 'Prerequisites',
                'type'  => 'Article',
                'slug'  => 'onboarding-prerequisites',
                'body' => $faker->text(500),
                'completion_time' => 60
            ],
            [
                'title' => 'Creating the Active Directory Account',
                'type'  => 'Article',
                'slug'  => 'onboarding-active-directory',
                'body' => $faker->text(500),
                'completion_time' => 600
            ],
            [
                'title' => 'Generating the Password Sheet & Welcome Letter',
                'type'  => 'Article',
                'slug'  => 'onboarding-password-sheet',
                'body' => $faker->text(500),
                'completion_time' => 300
            ],
            [
                'title' => 'Creating External Accounts',
                'type'  => 'Article',
                'slug'  => 'onboarding-external-accounts',
                'body' => $faker->text(500),
                'completion_time' => 600
            ],
            [
                'title' => 'Creating IDD Specific Accounts',
                'type'  => 'Article',
                'slug'  => 'onboarding-idd-specific-accounts',
                'body' => $faker->text(500),
                'completion_time' => 600
            ],
            [
                'title' => 'Creating IT Specific Accounts',
                'type'  => 'Article',
                'slug'  => 'onboarding-it-specific-accounts',
                'body' => $faker->text(500),
                'completion_time' => 1200
            ],
            [
                'title' => 'Creating HR Specific Accounts',
                'type'  => 'Article',
                'slug'  => 'onboarding-hr-specific-accounts',
                'body' => $faker->text(500),
                'completion_time' => 600
            ],
            [
                'title' => 'Deploy a Windows 10 Laptop',
                'type'  => 'Article',
                'slug'  => 'onboarding-deploy-windows-laptop',
                'body' => $faker->text(500),
                'completion_time' => 1800
            ],
            [
                'title' => 'Deploy a Windows 10 Desktop',
                'type'  => 'Article',
                'slug'  => 'onboarding-deploy-windows-desktop',
                'body' => $faker->text(500),
                'completion_time' => 1800
            ],
            [
                'title' => 'Deploy an Apple iPhone',
                'type'  => 'Article',
                'slug'  => 'onboarding-deploy-apple-iphone',
                'body' => $faker->text(500),
                'completion_time' => 1800
            ],
            [
                'title' => 'Deploy a Mobile Printer',
                'type'  => 'Article',
                'slug'  => 'onboarding-deploy-mobile-printer',
                'body' => $faker->text(500),
                'completion_time' => 600
            ]
        ];

        foreach($items as $record)
        {
            \App\Lecture::create($record);
        }
    }
}
