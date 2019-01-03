<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseUser;
use App\Http\Requests\EditsCourses;
use Illuminate\Http\Request;
use App\Http\Requests\CreatesCourses;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        $my_courses = CourseUser::mine()->whereNull('completed_at')->get();

        return view('courses.index', [
            'courses'       => $courses,
            'my_courses'    => $my_courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatesCourses  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesCourses $request)
    {
        $course = Course::create([
            'title'             => $request->input('title'),
            'slug'              => $request->input('slug'),
            'recertify_interval'=> $request->input('recertify_interval'),
            'short_description' => $request->input('short_description'),
            'long_description'  => $request->input('long_description'),
        ]);

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('assignedLessons', 'assignedLessons.lesson', 'assignedLessons.lesson.assignedLectures', 'assignedLessons.lesson.assignedLectures.lecture');

        return view('courses.show', [
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('courses.edit', [
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditsCourses  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(EditsCourses $request, Course $course)
    {
        $course->update([
            'title'             => $request->input('title'),
            'slug'              => $request->input('slug'),
            'recertify_interval'=> $request->input('recertify_interval'),
            'short_description' => $request->input('short_description'),
            'long_description'  => $request->input('long_description'),
        ]);

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
