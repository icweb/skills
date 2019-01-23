<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseLesson;
use App\CourseUser;
use App\Http\Requests\EditsCourses;
use App\Lecture;
use App\LectureLesson;
use App\LectureUser;
use App\Lesson;
use App\User;
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
            'color'             => $request->input('color'),
        ]);

        if(!empty($request->input('demo-data')) && $request->input('demo-data') === 'true')
        {
            $lesson = Lesson::create([
                'title' => 'Sample Lesson',
                'slug'  => 'sample-lesson-' . $request->input('slug'),
                'demo'  => 1
            ]);

            $course->assignedLessons()->create(['lesson_id' => $lesson->id]);

            $lectures = [
                [
                    'title'             => 'Creating your first lesson',
                    'slug'              => 'sample-lecture-' . '-' . random_int(100000,999999),
                    'type'              => 'Article',
                    'completion_time'   => 60,
                    'demo'              => 1
                ],
                [
                    'title'             => 'Creating your first lecture',
                    'slug'              => 'sample-lecture-' . '-' . random_int(100000,999999),
                    'type'              => 'Article',
                    'completion_time'   => 60,
                    'demo'              => 1
                ]
            ];

            foreach($lectures as $lecture)
            {
                $new_lecture = Lecture::create($lecture);
                $lesson->assignedLectures()->create(['lecture_id' => $new_lecture->id]);
            }
        }

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
            'color'             => $request->input('color'),
        ]);

        if(!empty($request->input('order')))
        {
            foreach(json_decode($request->input('order'))[0] as $key => $val)
            {
                $course->assignedLessons()->where('lesson_id', $val->id)->update(['position' => $key + 1]);
            }
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index');
    }

    public function certificate(User $user, Course $course)
    {
        $course_user = $user
            ->assignedCourses()
            ->whereNotNull('completed_at')
            ->where(['course_id' => $course->id])
            ->first();

        if(isset($course_user->id))
        {
            return view('courses.certificate', [
                'name'      => $user->name,
                'subject'   => $course_user->course->title,
                'date'      => $course_user->completed_at->format('l, F d, Y'),
            ]);
        }
        else
        {
            return abort(404);
        }
    }

    public function completed(Request $request, Course $course)
    {
        return view('courses.completed', [
            'course'    => $course
        ]);
    }

    public function manage(Request $request, Course $course)
    {
        $users_view = isset($_GET['u_view']) ? $_GET['u_view'] : 'all';

        $all_users = User::orderBy('name', 'asc')->get();
        $course_user = $course->assignedUsers();

        if($users_view === 'completed')
        {
            $course_user = $course_user->whereNotNull('completed_at');
        }
        else if($users_view === 'incomplete')
        {
            $course_user = $course_user->whereNull('completed_at');
        }
        else if($users_view === 'due_soon')
        {
            $course_user = $course_user->whereNull('completed_at')->where('due_at', '<', date('Y-m-d', strtotime('+ 90 days')));
        }
        else if($users_view === 'recent')
        {
            $course_user = $course_user->orderBy('id', 'desc')->limit(10);
        }
        else if($users_view === 'late')
        {
            $course_user = $course_user->whereNull('completed_at')->where('due_at', '<', date('Y-m-d', time()));
        }
        else
        {
            $users_view = 'all';
        }

        $course_user = $course_user->get();

        return view('courses.manage', [
            'course'         => $course,
            'all_users'      => $all_users,
            'course_user'    => $course_user,
            'users_view'     => $users_view,
        ]);
    }

    public function assign(Request $request, Course $course)
    {
        foreach($request->input('assigned_users') as $item)
        {
            $course->assignedUsers()->create(['user_id' => $item, 'due_at' => $request->input('due_at')]);
        }

        return redirect()->back();
    }

    public function assignUpdate(Request $request, Course $course, $assignId)
    {
        $course_user = CourseUser::findOrFail($assignId);

        if($request->input('editType') === 'delete')
        {
            $course_user->delete();
        }
        else
        {
            // Loop through all the lessons
            foreach($course->assignedLessons()->get() as $lesson)
            {
                // Loop through all of the lectures
                foreach($lesson->lesson->assignedLectures as $lecture)
                {
                    $lecture->lecture->markAsCompleted($course, $course_user->assignedUser, false);
                }
            }

            $course_user->markAsComplete($request->input('completed_at'));
        }

        return redirect()->back();
    }
}
