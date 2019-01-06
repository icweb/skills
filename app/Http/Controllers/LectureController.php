<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\EditsLectures;
use App\LectureLesson;
use App\Lesson;
use App\Course;
use App\Lecture;
use App\Question;
use App\Skill;
use App\SkillUser;
use Illuminate\Http\Request;
use App\Http\Requests\CreatesLectures;

class LectureController extends Controller
{
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
        $existing_lectures = Lecture::orderBy('title', 'asc')->get();
        $skills = Skill::orderBy('title', 'asc')->get();

        return view('lectures.create', [
            'skills'            => $skills,
            'course'            => $course,
            'lesson'            => $lesson,
            'lecture_types'     => $lecture_types,
            'existing_lectures' => $existing_lectures
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
        if($request->input('creation') === 'new')
        {
            $lecture = Lecture::create([
                'title'                 => $request->input('title'),
                'slug'                  => $request->input('slug'),
                'type'                  => $request->input('type'),
                'completion_time'       => $request->input('completion_time'),
            ]);
        }
        else
        {
            $lecture = Lecture::findOrFail($request->input('existing_lecture'));
        }

        $lesson->assignedLectures()->create(['lecture_id' => $lecture->id]);

        foreach($request->all() as $key => $val)
        {
            if(substr($key, 0, 18) === 'associated_skills_')
            {
                $skill_id = explode('_', $key);

                if(count($lecture->assignedSkills()->where('skill_id', $skill_id[2])->get()) < 1)
                {
                    $lecture->assignedSkills()->create(['skill_id' => $skill_id[2]]);
                }
            }
        }

        return redirect()->route('lectures.edit', [$course, $lesson, $lecture]);
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
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, Lesson $lesson, Lecture $lecture)
    {
        $lecture_types = Lecture::types();
        $skills = Skill::orderBy('title', 'asc')->get();

        $lecture->with('questions', 'questions.answers');

        return view('lectures.edit', [
            'skills'        => $skills,
            'course'        => $course,
            'lesson'        => $lesson,
            'lecture'       => $lecture,
            'lecture_types' => $lecture_types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditsLectures $request
     * @param  \App\Course $course
     * @param  \App\Lesson $lesson
     * @param  \App\Lecture $lecture
     * @return \Illuminate\Http\Response
     */
    public function update(EditsLectures $request, Course $course, Lesson $lesson, Lecture $lecture)
    {
        $lecture->update([
            'title'                 => $request->input('title'),
            'slug'                  => $request->input('slug'),
            'type'                  => $request->input('type'),
            'completion_time'       => $request->input('completion_time'),
        ]);

        $lecture->assignedSkills()->delete();

        foreach($request->all() as $key => $val)
        {
            if(substr($key, 0, 18) === 'associated_skills_')
            {
                $skill_id = explode('_', $key);
                $lecture->assignedSkills()->create(['skill_id' => $skill_id[2]]);
            }
        }

        if($request->input('type') === 'Article')
        {
            // See if lecture has existing file that should be deleted first
            $lecture->removeFileIfExists();

            // Update the body
            $lecture->update(['body' => $request->input('article_body')]);

            // Delete questions and answers
            $question_ids = $lecture->questions()->select('id')->get()->pluck('id')->toArray();
            Answer::whereIn('question_id', $question_ids)->delete();
            $lecture->questions()->delete();
        }
        else if(
            $request->input('type') === 'Download'
            && $request->hasFile('download_file')
            && $request->file('download_file')->isValid()
        )
        {
            // See if lecture has existing file that should be deleted first
            $lecture->removeFileIfExists();

            // Uploads the file and returns directory path
            $file_path = $request->file('download_file')->store('lecture-uploads');

            // Create the database record of the file
            $lecture->file()->create([
                'title'         => $request->file('download_file')->getClientOriginalName(),
                'size'          => $request->file('download_file')->getSize(),
                'type'          => $request->file('download_file')->getType(),
                'extension'     => $request->file('download_file')->getClientOriginalExtension(),
                'full_name'     => $request->file('download_file')->getClientOriginalName(),
                'path'          => $file_path,

            ]);

            // Clear out the body
            $lecture->update(['body' => null]);

            // Delete questions and answers
            $question_ids = $lecture->questions()->select('id')->get()->pluck('id')->toArray();
            Answer::whereIn('question_id', $question_ids)->delete();
            $lecture->questions()->delete();
        }
        else if($request->input('type') === 'Quiz')
        {
            if(!empty($request->input('question-titles')))
            {
                // Loop through questions
                foreach($request->input('question-titles') as $key => $val)
                {
                    $question = Question::findOrFail($key);

                    if($val === '&DELETE')
                    {
                        $question->answers()->delete();
                        $question->delete();
                    }
                    else
                    {
                        if(!empty($request->input('correctAnswer')))
                        {
                            foreach($request->input('correctAnswer') as $key2 => $val2)
                            {
                                if($key2 == $question->id)
                                {
                                    $correct_answer = $val2;
                                }
                            }

                            if(isset($correct_answer))
                            {
                                $question->update(['answer_id' => $correct_answer]);
                            }
                        }

                        $question->update(['title' => $val]);
                    }
                }

                // Loop through question answers
                if(!empty($request->input('answer-titles')))
                {
                    foreach($request->input('answer-titles') as $key => $val)
                    {
                        $answer = Answer::find($key);

                        if(isset($answer->id))
                        {
                            if($val === '&DELETE')
                            {
                                $answer->delete();
                            }
                            else
                            {
                                $answer->update(['title' => $val]);
                            }
                        }
                    }
                }
            }

            // See if lecture has existing file that should be deleted first
            $lecture->removeFileIfExists();

            // Clear out the body
            $lecture->update(['body' => null]);
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Course $course, Lesson $lesson, Lecture $lecture)
    {
        $lecture->removeFileIfExists();
        $question_ids = $lecture->questions()->select('id')->get()->pluck('id')->toArray();
        Answer::whereIn('question_id', $question_ids)->delete();
        $lecture->questions()->delete();

        if($request->input('delete_type') === 'soft')
        {
            $lesson->assignedLectures()->where('lecture_id', $lecture->id)->delete();
        }
        else
        {
            LectureLesson::where('lecture_id', $lecture->id)->delete();
            $lecture->delete();
        }

        return redirect()->away(route('courses.show', $course) . '#editLessons');
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

        foreach($lecture->assignedSkills as $skill)
        {
            SkillUser::create([
                'user_id'       => auth()->user()->id,
                'skill_id'      => $skill->skill->id,
                'time_earned'   => $lecture->completion_time
            ]);
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

        if($lecture->type === 'Download')
        {
            return response()->download(storage_path('app/' . $lecture->file->path));
        }
        else
        {
            return redirect()->route('courses.show', $course);
        }
    }
}
