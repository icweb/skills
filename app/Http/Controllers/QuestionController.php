<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lecture;
use App\Lesson;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Course $course
     * @param  Lesson $lesson
     * @param  Lecture $lecture
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, Lesson $lesson, Lecture $lecture)
    {
        $question = $lecture->questions()->create(['title' => '?']);

        return response()->json([
            'id'   => $question->id,
            'url'  => route('answers.store', [$course, $lesson, $lecture, $question])
        ]);
    }
}
