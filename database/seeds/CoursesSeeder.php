<?php

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
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
                'title'             => 'Beginners to PHP',
                'slug'              => 'beginners-to-php',
                'recertify_interval'=> random_int(1,60)
            ],
            [
                'title'             => 'Beginners to HTML',
                'slug'              => 'beginners-to-html',
                'recertify_interval'=> random_int(1,60)
            ],
            [
                'title'             => 'Beginners to JavaScript',
                'slug'              => 'beginners-to-javascript',
                'recertify_interval'=> random_int(1,60)
            ],
            [
                'title'             => 'Beginners to CSS',
                'slug'              => 'beginners-to-css',
                'recertify_interval'=> random_int(1,60)
            ]
        ];

        foreach($items as $record)
        {
            $record['short_description'] = $faker->text(random_int(50,250));
            $record['long_description'] = $faker->text(random_int(250,500));

            \App\Course::create($record);
        }
    }
}
