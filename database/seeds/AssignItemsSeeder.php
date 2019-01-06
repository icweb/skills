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

            [
                'course_id' => 5,
                'lesson_id' => 5,
            ],
            [
                'course_id' => 5,
                'lesson_id' => 6,
            ],
            [
                'course_id' => 5,
                'lesson_id' => 7,
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


            [
                'lesson_id'     => 5,
                'lecture_id'    => 9,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 10,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 11,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 12,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 13,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 14,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 15,
            ],

            [
                'lesson_id'     => 7,
                'lecture_id'    => 16,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 17,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 18,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 19,
            ],
        ];

        foreach($lesson_lectures as $record)
        {
            \App\LectureLesson::create($record);
        }

        $lesson_skills = [
            [
                'skill_id'      => 1,
                'lecture_id'    => 1,
            ],
            [
                'skill_id'      => 1,
                'lecture_id'    => 2,
            ],
            [
                'skill_id'      => 2,
                'lecture_id'    => 3,
            ],
            [
                'skill_id'      => 2,
                'lecture_id'    => 4,
            ],
            [
                'skill_id'      => 3,
                'lecture_id'    => 5,
            ],
            [
                'skill_id'      => 3,
                'lecture_id'    => 6,
            ],
            [
                'skill_id'      => 4,
                'lecture_id'    => 7,
            ],
            [
                'skill_id'      => 4,
                'lecture_id'    => 8,
            ],

            [
                'skill_id'      => 5,
                'lecture_id'    => 10,
            ],
            [
                'skill_id'      => 6,
                'lecture_id'    => 16,
            ],
            [
                'skill_id'      => 6,
                'lecture_id'    => 17,
            ],
            [
                'skill_id'      => 7,
                'lecture_id'    => 18,
            ],
            [
                'skill_id'      => 8,
                'lecture_id'    => 13,
            ],
        ];

        foreach($lesson_skills as $record)
        {
            \App\LectureSkill::create($record);
        }

        foreach(\App\User::all() as $record)
        {
            for($x = 5; $x < 6; $x++)
            {
                \App\CourseUser::create([
                    'course_id' => $x,
                    'user_id' => $record->id
                ]);
            }
        }
    }
}
