@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid course-jumbotron bg-success" style="padding: 2rem 4rem 2rem 4rem;margin-bottom:0;color: #ffffff">
        <h1 class="display-4" style="font-size:36px;">{{ $course->title }}</h1>
    </div>
    <div class="container">
        <div class="card mt-40">
            <div class="card-body">
                <h2>Congratulations, {{ auth()->user()->name }}!</h2>
                You completed the course <b>{{ $course->title }}</b>. You can download a course completion certificate below, or view your progress on the skills page. Your course completion certificate will be saved to your account for download at a later time.
            </div>
        </div>
        <div class="card mt-40">
            <div class="card-body">
                <h4>Course Resources</h4>
                <p class="mb-20">Click a related resource below to view more</p>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('courses.certificate', [auth()->user(), $course]) }}" target="_blank" class="btn btn-outline-success btn-block text-left mt-20 mb-20">
                            <table style="width:100%;margin:10px 0;">
                                <tr>
                                    <td style="width: 50px;">
                                        <em class="fa fa-download pull-left fa-2x"></em><br>
                                    </td>
                                    <td>
                                        <h2 class="mb-0">Download Certificate</h2>
                                    </td>
                                </tr>
                            </table>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('skills.index', [auth()->user()]) }}" class="btn btn-outline-success btn-block text-left mt-20 mb-20">
                            <table style="width:100%;margin:10px 0;">
                                <tr>
                                    <td style="width: 50px;">
                                        <em class="fa fa-bar-chart pull-left fa-2x"></em><br>
                                    </td>
                                    <td>
                                        <h2 class="mb-0">View My Skills</h2>
                                    </td>
                                </tr>
                            </table>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-40">
            <div class="card-body">
                <h4>Skills You Earned</h4>
                <p class="mb-20">Click a skill below to view related courses</p>
                <div class="row">
                    @foreach($course->skills() as $skill)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-20">
                            <form action="{{ route('library.search') }}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="skill" value="{{ $skill->title }}">
                                <button type="submit" class="btn btn-default btn-lg btn-block" style="color:{{ $skill->color }};border: 1px solid {{ $skill->color }};width: 100%;">
                                    <br>
                                    <em class="fa fa-{{ $skill->icon }} fa-2x"></em> <br><br>
                                    <h4 class="mb-0">{{ $skill->title }}</h4>
                                    <br>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

