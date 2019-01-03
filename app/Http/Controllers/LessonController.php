<?php

namespace App\Http\Controllers;

use App\CourseLesson;
use App\Http\Requests\EditsLessons;
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
        $existing_lessons = Lesson::orderBy('title')->get();

        return view('lessons.create', [
            'course'            => $course,
            'skills'            => $skills,
            'existing_lessons'  => $existing_lessons
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
        if($request->input('creation') === 'new')
        {
            $lesson = Lesson::create([
                'title' => $request->input('title'),
                'slug'  => $request->input('slug'),
            ]);
        }
        else
        {
            $lesson = Lesson::findOrFail($request->input('existing_lesson'));
        }

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
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, Lesson $lesson)
    {
        return view('lessons.show', [
            'course' => $course,
            'lesson' => $lesson
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course $course
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, Lesson $lesson)
    {
        $skills = Skill::orderBy('title', 'asc')->get();

        return view('lessons.edit', [
            'course' => $course,
            'lesson' => $lesson,
            'skills' => $skills
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditsLessons $request
     * @param  \App\Course $course
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(EditsLessons $request, Course $course, Lesson $lesson)
    {
        $lesson->update([
            'title' => $request->input('title'),
            'slug'  => $request->input('slug'),
        ]);

        $lesson->assignedSkills()->delete();

        foreach($request->all() as $key => $val)
        {
            if(substr($key, 0, 18) === 'associated_skills_')
            {
                $skill_id = explode('_', $key);
                $lesson->assignedSkills()->create(['skill_id' => $skill_id[2]]);
            }
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  \App\Course $course
     * @param  \App\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course, Lesson $lesson)
    {
        if($request->input('delete_type') === 'soft')
        {
            $course->assignedLessons()->where('id', $lesson->id)->delete();
        }
        else
        {
            CourseLesson::where('lesson_id', $lesson->id)->delete();
            $lesson->delete();
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }
}
