<?php

namespace App\Http\Controllers;

use App\User;
use App\Skill;
use App\SkillUser;
use App\CourseUser;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $skills = Skill::all();

        $my_skills = SkillUser::selectRaw('COUNT(user_id) as skill_count, skill_id, SUM(time_earned) as time_earned')
            ->with('skill')
            ->where(['user_id' => auth()->user()->id])
            ->orderBy('time_earned', 'DESC')
            ->groupBy('skill_id')
            ->get();

        $upcoming_receritifcations = CourseUser::selectRaw("MAX(course_id) as course_id, MAX(recertify_at) as recertify_at")
            ->with('course')
            ->where(['user_id' => auth()->user()->id])
            ->whereBetween('recertify_at', [date('Y-m-d', time()), date('Y-m-d', strtotime('+ 30 Days'))])
            ->groupBy('course_id')
            ->get();

        $late_receritifcations = CourseUser::selectRaw("MAX(course_id) as course_id, MAX(recertify_at) as recertify_at")
            ->with('course')
            ->where(['user_id' => auth()->user()->id])
            ->where('recertify_at', '<=', date('Y-m-d', time()))
            ->groupBy('course_id')
            ->get();

        $certificates = $user
            ->assignedCourses()
            ->selectRaw('MAX(completed_at) as completed_at, MAX(course_id) as course_id')
            ->with(['course'])
            ->whereNotNull('completed_at')
            ->groupBy('course_id')
            ->get();

        return view('skills.index', [
            'user'                      => $user,
            'skills'                    => $skills,
            'mine'                      => $my_skills,
            'certificates'              => $certificates,
            'upcoming_receritifcations' => $upcoming_receritifcations,
            'late_receritifcations'     => $late_receritifcations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
