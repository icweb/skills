@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-body">
                    <h2 style="margin-bottom:0">Courses</h2>
                </div>
            </div>
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-sm-6 col-md-4">
                        <div class="card" style="margin-bottom:30px;height:300px;max-height:300px;">
                            <div class="card-body">
                                <h4 style="height:50px;">{{ $course->title }}</h4>
                                <p style="height:100px;overflow:hidden;">{{ $course->short_description }}</p>
                                <div style="height:30px;margin-bottom:10px;">
                                    @foreach($course->skills() as $skill)
                                        <span style="color:{{ $skill->color }};margin-right:5px;"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-sm-6 col-md-4">
                    <div class="card" style="margin-bottom:30px;height:300px;max-height:300px;">
                        <a href="{{ route('courses.create') }}">
                            <div class="card-body text-center" style="padding-top:100px;">
                                <em class="fa fa-plus fa-5x"></em><br>
                                <h4>Add Course</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
