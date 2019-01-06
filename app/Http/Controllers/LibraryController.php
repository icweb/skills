<?php

namespace App\Http\Controllers;

use App\Lecture;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Lecture::all();

        return view('lectures.index');
    }
}
