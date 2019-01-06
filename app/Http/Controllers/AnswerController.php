<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lecture;
use App\Lesson;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Course $course
     * @param  Lesson $lesson
     * @param  Lecture $lecture
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, Lesson $lesson, Lecture $lecture, Question $question)
    {
        $answer = $question->answers()->create(['title' => '?']);
        return $answer->id;
    }
}
