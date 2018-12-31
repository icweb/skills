<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@admin.com',
            'password'  => bcrypt('secret'),
        ]);

        for($x = 0; $x < 10; $x++)
        {
            \App\User::create([
                'name'      => $faker->name,
                'email'     => $faker->email,
                'password'  => bcrypt('secret'),
            ]);
        }
    }
}
