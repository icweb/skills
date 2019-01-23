<?php

namespace App\Http\Controllers;

use App\Answer;
use App\AnswerUser;
use App\Http\Requests\EditsLectures;
use App\LectureLesson;
use App\LectureUser;
use App\Lesson;
use App\Course;
use App\Lecture;
use App\Question;
use App\QuizScore;
use App\Skill;
use App\SkillUser;
use App\User;
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
            'skills'                => $skills,
            'course'                => $course,
            'lesson'                => $lesson,
            'lecture_types'         => $lecture_types,
            'existing_lectures'     => $existing_lectures
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
        if($request->input('creation_type') === 'new')
        {
            $lecture = Lecture::create([
                'title'                     => $request->input('title'),
                'slug'                      => $request->input('slug'),
                'type'                      => $request->input('type'),
                'completion_time'           => $request->input('completion_time'),
                'show_in_search'            => $request->input('show_in_search'),
                'show_certified_users'      => $request->input('show_certified_users'),
                'show_completion_history'   => $request->input('show_completion_history'),
                'body'                      => $request->input('type') === 'Download' ? 'Download this file to complete this lecture.' : ''
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
        $certified_users = $lecture
            ->assignedUsers()
            ->selectRaw('user_id, MAX(completed_at) as completed_at, MAX(id) as id')
            ->orderBy('id', 'desc')
            ->groupBy('user_id')
            ->get();

        $lecture_lesson = $lesson->assignedLectures()->orderBy('position', 'asc')->get();

        $show_answers = !empty(session('show_answers'));
        $answers = session('answers');
        $next = session('next');

        return view('lectures.show', [
            'course'            => $course,
            'lesson'            => $lesson,
            'lecture'           => $lecture,
            'certified_users'   => $certified_users,
            'lecture_lesson'    => $lecture_lesson,
            'show_answers'      => $show_answers,
            'answers'           => $answers,
            'next'              => $next,
            'lecture_user'      => $lecture->assignedUsers()->mine()->orderBy('id', 'desc')->get()
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
        $update_data = [
            'title'                     => $request->input('title'),
            'slug'                      => $request->input('slug'),
            'type'                      => $request->input('type'),
            'show_in_search'            => $request->input('show_in_search'),
            'completion_time'           => $request->input('completion_time'),
            'allow_print'               => $request->input('allow_print'),
            'show_certified_users'      => $request->input('show_certified_users'),
            'show_completion_history'   => $request->input('show_completion_history'),
        ];

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

            // Delete questions and answers
            $question_ids = $lecture->questions()->select('id')->get()->pluck('id')->toArray();
            Answer::whereIn('question_id', $question_ids)->delete();
            $lecture->questions()->delete();
        }
        else if($request->input('type') === 'Quiz')
        {
            $update_data['quiz_show_answers'] = $request->input('quiz_show_answers');
            $update_data['quiz_show_score'] = $request->input('quiz_show_score');
            $update_data['quiz_pass_to_complete'] = $request->input('quiz_pass_to_complete');
            $update_data['quiz_required_score'] = $request->input('quiz_required_score');

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

        }

        $update_data['body'] = $request->input('article_body');

        $lecture->update($update_data);

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
     * @param  Request  $request
     * @param  \App\Course  $course
     * @param  \App\Lesson  $lesson
     * @param  \App\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, Course $course, Lesson $lesson, Lecture $lecture)
    {
        $showAnswers = false;
        $advanceToNext = true;
        $error = '';

        if($lecture->type === 'Quiz')
        {
            $answersPicked = [];
            $totalQuestions = $lecture->questions()->count();
            $correctAnswers = 0;
            $incorrectAnswers = 0;

            foreach($request->all() as $key => $val)
            {
                // See if this input field is a quiz answer
                if(substr($key, 0, 3) === 'qq_')
                {
                    // Get the question ID out of the field name
                    // and then find the Question
                    $keyArray = explode('_', $key);
                    $question = Question::findOrFail($keyArray[1]);

                    // Find the answer they selected
                    $answer = Answer::findOrFail($val);

                    // Record the answer
                    $question->answerUser([
                        'answer_id' => $answer->id,
                        'user_id'   => auth()->user()->id
                    ]);

                    // Find out if this was the right answer
                    if($question->rightAnswer->id === $answer->id)
                    {
                        $correctAnswers += 1;
                    }
                    else
                    {
                        $incorrectAnswers += 1;
                    }

                    $answersPicked[$question->id] = $answer;
                }
            }

            // Find out if the user passed the test
            // and if they need to pass the test in
            // order ot mark this lecture as completed

            $requirePass = $lecture->quiz_pass_to_complete;
            $scoreReceived = round(($correctAnswers/$totalQuestions) * 100, 2);

            if($requirePass && $scoreReceived >= $lecture->quiz_required_score)
            {
                // The quiz must be passed in order to mark complete
                // and the user passed this quiz
                $lecture->markAsCompleted($course);
                $scoreStatus = 'Pass';
                $advanceToNext = !$lecture->quiz_show_answers;
                $showAnswers = $lecture->quiz_show_answers;
            }
            else if($requirePass && $scoreReceived <= $lecture->quiz_required_score)
            {
                // The quiz must be passed in order to mark complete
                // and the user did not passed this quiz
                $advanceToNext = false;
                $error = 'You did not pass this quiz.';
                $scoreStatus = 'Fail';
            }
            else if(!$requirePass)
            {
                // This quiz does not need to be passed in order
                // to mark as complete
                $lecture->markAsCompleted($course);
                $scoreStatus = 'Pass';
                $advanceToNext = !$lecture->quiz_show_answers;
                $showAnswers = $lecture->quiz_show_answers;
            }

            if(isset($scoreStatus))
            {
                // Record the score history
                $lecture->quizScore()->create([
                    'available' => $totalQuestions,
                    'answered'  => $correctAnswers + $incorrectAnswers,
                    'correct'   => $correctAnswers,
                    'incorrect' => $incorrectAnswers,
                    'user_id'   => auth()->user()->id,
                    'status'    => $scoreStatus
                ]);
            }
        }
        else if($lecture->type === 'Article')
        {
            $lecture->markAsCompleted($course);
        }
        else if($lecture->type === 'Download')
        {
            $lecture->markAsCompleted($course);
        }

        // Assignment
        $lesson_lecture = $lesson->assignedLectures()->where(['lecture_id' => $lecture->id])->first();

        if($course->isCompleted())
        {
            return redirect()->route('courses.completed', $course);
        }
        if(isset($lesson_lecture->next()->next->id) && $advanceToNext)
        {
            return redirect()->route('lectures.show', [$course, $lesson, $lesson_lecture->next()->next]);
        }
        else if(!$advanceToNext)
        {
            return redirect()
                ->route('lectures.show', [$course, $lesson, $lecture])
                ->withErrors([$error])
                ->with([
                    'show_answers' => $showAnswers,
                    'answers'      => $answersPicked,
                    'next'         => ''
                ]);
        }
        else
        {
            return redirect()->route('courses.show', [$course]);
        }

//        if($lecture->type === 'Download')
//        {
//            return response()->download(storage_path('app/' . $lecture->file->path));
//        }
//        else
//        {
//            return redirect()->route('courses.show', $course);
//        }
    }

    public function download(Request $request, Lecture $lecture)
    {
        return response()->download(storage_path('app/' . $lecture->file->path));
    }
}
