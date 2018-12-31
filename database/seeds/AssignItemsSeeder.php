<?php

use Illuminate\Database\Seeder;

class AssignItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        auth()->loginUsingId(5);

        $course_lessons = [
            [
                'course_id' => 1,
                'lesson_id' => 1,
            ],
            [
                'course_id' => 2,
                'lesson_id' => 2,
            ],
            [
                'course_id' => 3,
                'lesson_id' => 3,
            ],
            [
                'course_id' => 4,
                'lesson_id' => 4,
            ],
        ];

        foreach($course_lessons as $record)
        {
            \App\CourseLesson::create($record);
        }

        $lesson_lectures = [
            [
                'lesson_id'     => 1,
                'lecture_id'    => 1,
            ],
            [
                'lesson_id'     => 1,
                'lecture_id'    => 2,
            ],
            [
                'lesson_id'     => 2,
                'lecture_id'    => 3,
            ],
            [
                'lesson_id'     => 2,
                'lecture_id'    => 4,
            ],
            [
                'lesson_id'     => 3,
                'lecture_id'    => 5,
            ],
            [
                'lesson_id'     => 3,
                'lecture_id'    => 6,
            ],
            [
                'lesson_id'     => 4,
                'lecture_id'    => 7,
            ],
            [
                'lesson_id'     => 4,
                'lecture_id'    => 8,
            ],
        ];

        foreach($lesson_lectures as $record)
        {
            \App\LectureLesson::create($record);
        }

        $lesson_skills = [
            [
                'skill_id'  => 1,
                'lesson_id' => 1,
            ],
            [
                'skill_id'  => 2,
                'lesson_id' => 2,
            ],
            [
                'skill_id'  => 3,
                'lesson_id' => 3,
            ],
            [
                'skill_id'  => 4,
                'lesson_id' => 4,
            ],
        ];

        foreach($lesson_skills as $record)
        {
            \App\LessonSkill::create($record);
        }

        foreach(\App\User::all() as $record)
        {
            for($x = 1; $x < 5; $x++)
            {
                \App\CourseUser::create([
                    'course_id' => $x,
                    'user_id' => $record->id
                ]);
            }
        }
    }
}
