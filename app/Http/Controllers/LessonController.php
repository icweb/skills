<?php

namespace App\Http\Controllers;

use App\Skill;
use App\Course;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Requests\CreatesLessons;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Course $course
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
        $skills = Skill::orderBy('title', 'asc')->get();

        return view('lessons.create', [
            'course' => $course,
            'skills' => $skills
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatesLessons  $request
     * @param  Course $course
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesLessons $request, Course $course)
    {
        $lesson = Lesson::create([
            'title' => $request->input('title'),
            'slug'  => $request->input('slug'),
        ]);

        $course->assignedLessons()->create(['lesson_id' => $lesson->id]);

        foreach($request->all() as $key => $val)
        {
            if(substr($key, 0, 18) === 'associated_skills_')
            {
                $skill_id = explode('_', $key);

                if(count($lesson->assignedSkills()->where('skill_id', $skill_id[2])->get()) < 1)
                {
                    $lesson->assignedSkills()->create(['skill_id' => $skill_id[2]]);
                }
            }
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
