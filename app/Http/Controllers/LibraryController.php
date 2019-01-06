<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\LectureSkill;
use App\Skill;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('title')->get();
        $lecture_types = Lecture::types(true);

        return view('library.index', [
            'skills'        => $skills,
            'lecture_types' => $lecture_types
        ]);
    }

    public function search(Request $request)
    {
        if(!empty($request->input('title')))
        {
            $lectures = Lecture::where('title', 'LIKE', '%' . $request->input('title') . '%')
                ->orWhere('body', 'LIKE', '%' . $request->input('title') . '%')
                ->visible()
                ->get();

            $skill = [];
        }
        else if(!empty($request->input('skill')))
        {
            $skill_ids = Skill::select('id')
                ->where('title', $request->input('skill'))
                ->get();

            $skill = Skill::findOrFail($skill_ids[0]->id);

            $lecture_ids = LectureSkill::select('lecture_id')
                ->whereIn('skill_id', $skill_ids)
                ->get();

            $lectures = Lecture::whereIn('id', $lecture_ids)->visible()->get();
        }
        else if(!empty($request->input('type')))
        {
            $skill = [];
            $lectures = Lecture::whereType($request->input('type'))->visible()->get();
        }
        else
        {
            $skill = [];
            $lectures = [];
        }


        return view('library.results', [
            'lectures' => $lectures,
            'skill'    => $skill,
            'criteria' => [
                'title' => $request->input('title'),
                'skill' => $request->input('skill'),
                'type'  => $request->input('type'),
            ]
        ]);
    }
}
