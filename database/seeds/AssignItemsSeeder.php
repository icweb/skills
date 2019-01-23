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
                'position'  => 1,
            ],
            [
                'course_id' => 2,
                'lesson_id' => 2,
                'position'  => 1,
            ],
            [
                'course_id' => 3,
                'lesson_id' => 3,
                'position'  => 1,
            ],
            [
                'course_id' => 4,
                'lesson_id' => 4,
                'position'  => 1,
            ],

            [
                'course_id' => 5,
                'lesson_id' => 5,
                'position'  => 1,
            ],
            [
                'course_id' => 5,
                'lesson_id' => 6,
                'position'  => 2,
            ],
            [
                'course_id' => 5,
                'lesson_id' => 7,
                'position'  => 3,
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
                'position'      => 1,
            ],
            [
                'lesson_id'     => 1,
                'lecture_id'    => 2,
                'position'      => 2,
            ],
            [
                'lesson_id'     => 2,
                'lecture_id'    => 3,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 2,
                'lecture_id'    => 4,
                'position'      => 2,
            ],
            [
                'lesson_id'     => 3,
                'lecture_id'    => 5,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 3,
                'lecture_id'    => 6,
                'position'      => 2,
            ],
            [
                'lesson_id'     => 4,
                'lecture_id'    => 7,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 4,
                'lecture_id'    => 8,
                'position'      => 2,
            ],


            [
                'lesson_id'     => 5,
                'lecture_id'    => 9,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 10,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 11,
                'position'      => 2,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 12,
                'position'      => 3,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 13,
                'position'      => 4,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 14,
                'position'      => 5,
            ],
            [
                'lesson_id'     => 6,
                'lecture_id'    => 15,
                'position'      => 6,
            ],

            [
                'lesson_id'     => 7,
                'lecture_id'    => 16,
                'position'      => 1,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 17,
                'position'      => 2,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 18,
                'position'      => 3,
            ],
            [
                'lesson_id'     => 7,
                'lecture_id'    => 19,
                'position'      => 3,
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

//        foreach(\App\User::all() as $record)
//        {
////            for($x = 5; $x < 6; $x++)
////            {
////                \App\CourseUser::create([
////                    'course_id' => $x,
////                    'user_id' => $record->id
////                ]);
////            }
//
//            foreach(\App\Course::all() as $course)
//            {
//                $course->assignedUsers()->create(['user_id' => $record->id, 'completed_at' => null, 'due_at' => strtotime('+ 30 Days')]);
//
////                foreach($course->assignedLessons as $lesson)
////                {
////                    $lesson->lesson->assignedUsers()->create(['user_id' => $record->id, 'completed_at' => null]);
////
////                    foreach($lesson->lesson->assignedLectures as $lecture)
////                    {
////                        $lecture->lecture->assignedUsers()->create(['user_id' => $record->id, 'completed_at' => null]);
////                    }
////                }
//            }
//        }
    }
}
