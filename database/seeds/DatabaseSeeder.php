<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(SkillsSeeder::class);
        $this->call(CoursesSeeder::class);
        $this->call(LessonsSeeder::class);
        $this->call(LecturesSeeder::class);
        $this->call(QuestionsSeeder::class);

        $this->call(AssignItemsSeeder::class);
    }
}
