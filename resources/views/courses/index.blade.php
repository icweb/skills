@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(count($my_courses))
            <div class="col-md-12 mt-40 mb-40">
                <h2 class="mb-40">My Assigned Courses</h2>
                <div class="row">
                    @foreach($my_courses as $my_course)
                        <div class="col-md-6 col-lg-4">
                            <div class="card my-course-card">
                                <div class="bg-success course-success-badge">
                                    <em class="fa fa-star"></em>
                                    <div class="badge-arrow-up"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="course-card-title">{{ $my_course->course->title }}</h4>
                                    <p class="course-card-description">{{ $my_course->course->short_description }}</p>
                                    <a href="{{ route('courses.show', $my_course->course) }}" class="btn btn-success">Complete</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <h2 class="mb-40">All Courses</h2>
            <div class="row">
                <div class="col-md-6 col-lg-4 half-opacity">
                    <div class="card course-card">
                        <a href="{{ route('courses.create') }}">
                            <div class="card-body text-center pt-100">
                                <em class="fa fa-plus fa-5x"></em><br>
                                <h4>Add Course</h4>
                            </div>
                        </a>
                    </div>
                </div>
                @foreach($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="card course-card">
                            <div class="card-body">
                                <h4 class="course-card-title">{{ $course->title }}</h4>
                                <p class="course-card-description">{{ $course->short_description }}</p>
                                <div class="course_skills">
                                    @foreach($course->skills() as $skill)
                                        <span style="color:{{ $skill->color }};" class="skill-badge"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
