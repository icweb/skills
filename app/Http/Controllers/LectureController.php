<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Course;
use App\Lecture;
use App\SkillUser;
use Illuminate\Http\Request;
use App\Http\Requests\CreatesLectures;

class LectureController extends Controller
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
     * @param Course $course
     * @param Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course, Lesson $lesson)
    {
        $lecture_types = Lecture::types();

        return view('lectures.create', [
            'course'        => $course,
            'lesson'        => $lesson,
            'lecture_types' => $lecture_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Course $course
     * @param Lesson $lesson
     * @param  CreatesLectures  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatesLectures $request, Course $course, Lesson $lesson)
    {
        $lecture = Lecture::create([
            'title'     => $request->input('title'),
            'slug'      => $request->input('slug'),
            'type'      => $request->input('type'),
        ]);

        $lesson->assignedLectures()->create(['lecture_id' => $lecture->id]);

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, Lesson $lesson, Lecture $lecture)
    {
        return view('lectures.show', [
            'course'        => $course,
            'lesson'        => $lesson,
            'lecture'       => $lecture,
            'lecture_user'  => $lecture->assignedUsers()->mine()->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function edit(Lecture $lecture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecture $lecture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecture $lecture)
    {
        //
    }

    /**
     * Mark item as completed
     *
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function complete(Course $course, Lesson $lesson, Lecture $lecture)
    {
        $lecture->assignedUsers()
            ->create([
                'completed_at'  => time(),
                'user_id'       => auth()->user()->id
            ]);

        if($lesson->isCompleted(false))
        {
            foreach($lesson->assignedSkills as $skill)
            {
                SkillUser::create([
                    'user_id' => auth()->user()->id,
                    'skill_id' => $skill->skill->id
                ]);
            }
        }

        if($course->isCompleted())
        {
            // Find out if the user has completed this course before
            $existing_record = $course->assignedUsers()
                ->where(['user_id' => auth()->user()->id])
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();

            if(count($existing_record))
            {
                if(isset($existing_record[0]->completed_at))
                {
                    // This is a recertification so delete the old record
                    $existing_record[0]->delete();

                    $course->assignedUsers()
                        ->create([
                            'completed_at'  => time(),
                            'user_id'       => auth()->user()->id,
                            'recertify_at'  => strtotime(' + ' . $course->recertify_interval . ' Days')
                        ]);
                }
                else
                {
                    // This course was assigned to the user
                    $existing_record[0]->update([
                        'completed_at'  => time(),
                        'recertify_at'  => strtotime(' + ' . $course->recertify_interval . ' Days')
                    ]);
                }
            }
            else
            {
                // The user wasn't assigned to this course but
                // we'll let them complete it
                $course->assignedUsers()
                    ->create([
                        'completed_at'  => time(),
                        'user_id'       => auth()->user()->id,
                        'recertify_at'  => strtotime(' + ' . $course->recertify_interval . ' Days')
                    ]);
            }
        }

        return redirect()->route('courses.show', $course);
    }
}
