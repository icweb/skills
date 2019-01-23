<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lecture;
use App\LectureFavorite;
use App\Lesson;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites;

        return view('favorites.index', ['favorites' => $favorites]);
    }

    public function store(Request $request, Course $course, Lesson $lesson, Lecture $lecture)
    {
        $existing = LectureFavorite::where([
            'lecture_id' => $lecture->id,
            'user_id'    => auth()->user()->id
        ])->get();

        if(count($existing))
        {
            $existing[0]->delete();
        }
        else
        {
            LectureFavorite::create([
                'lecture_id' => $lecture->id,
                'user_id'    => auth()->user()->id
            ]);
        }

        return redirect()->route('lectures.show', [$course, $lesson, $lecture]);
    }

    public function storeWithoutCourse(Request $request, Lecture $lecture)
    {
        $existing = LectureFavorite::where([
            'lecture_id' => $lecture->id,
            'user_id'    => auth()->user()->id
        ])->get();

        if(count($existing))
        {
            $existing[0]->delete();
        }
        else
        {
            LectureFavorite::create([
                'lecture_id' => $lecture->id,
                'user_id'    => auth()->user()->id
            ]);
        }

        return redirect()->route('library.show', [$lecture]);
    }
}
