@extends('layouts.app')

@section('content')
    <div class="page">
        <div class="jumbotron jumbotron-fluid" style="padding: 2rem 4rem 2rem 4rem;margin-bottom:0;color: #ffffff;background-color:{{ $course->color }}">
            <h1 class="display-4" style="font-size:36px;">{{ $course->title }}</h1>
            <div class="card-completion mb-20" style="color: #ffffff !important;"><em class="fa fa-clock-o"></em> Completion Time: {{ $course->completionTime() }}</div>
            <div class="show-on-lessons-edit">
                <a href="{{ route('courses.edit', [$course]) }}" class="btn btn-lg text-white" style="border: 1px solid #ffffff"><em class="fa fa-pencil"></em> Edit Details</a>
                <a class="btn btn-lg text-white" style="border: 1px solid #ffffff" href="javascript:void(0)" id="previewLessonsButton"><em class="fa fa-times"></em> Exit Edit Mode</a>
            </div>
            <div class="hide-on-lessons-edit">
                <a href="{{ route('lectures.show', [$course, $course->first()->lesson, $course->first()->lecture]) }}" class="btn btn-lg text-white" style="border: 1px solid #ffffff"><em class="fa fa-play-circle"></em> Start Course</a>
                <div class="dropdown pull-left mr-5 ">
                    <a class="btn dropdown-toggle btn-lg text-white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #ffffff">
                        <em class="fa fa-cog"></em>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="javascript:void(0)" id="editLessonsButton">Edit Course</a>
                        <a class="dropdown-item" href="{{ route('courses.manage', $course) }}">Manage Course</a>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 10px 75px;">
            <div class="row">
                <div class="col-12">
                    <div class="mt-40 mb-40 hide-on-lessons-edit">
                        @if(count($course->skills()))
                            <h4 class="mb-10">Skills you will earn</h4>
                            @include('partials.section-skills', ['skills' => $course->skills()])
                            <hr>
                        @endif
                        <h4>About this course</h4>
                        <span class="mb-30 articleBodyHtml">{!! $course->long_description !!}</span>
                    </div>
                    {{--@if($course->isCompleted() && count($course->assignedLessons) > 0)--}}
                    {{--<div class="card bg-success text-white mb-30 hide-on-lessons-edit hide-on-course-edit">--}}
                    {{--<div class="card-body">--}}
                    {{--<h4><em class="fa fa-check"></em> Course Completed</h4>--}}
                    {{--You completed this course--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                </div>
                <div class="col-12">
                    <div class="mt-40 mb-30 show-on-lessons-edit text-center">
                        <a href="{{ route('lessons.create', [$course]) }}" class="btn btn-success"><em class="fa fa-plus"></em> Add Lesson</a>
                    </div>
                    @foreach($course->assignedLessons()->orderBy('position', 'asc')->get() as $assigned_lesson)
                        @include('partials.panel-lesson', ['lesson' => $assigned_lesson->lesson])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Course = {

            showEditLessons: function(){

                window.location.hash = 'editLessons';
                $('.hide-on-lessons-edit').hide();
                $('.show-on-lessons-edit').show();

            },

            hideEditLessons: function(){

                window.location.hash = '';
                $('.hide-on-lessons-edit').show();
                $('.show-on-lessons-edit').hide();

            },

            created: function(){

                $('#editLessonsButton').on('click', Course.showEditLessons);
                $('#previewLessonsButton').on('click', Course.hideEditLessons);

            }

        };

        $(document).ready(function(){

            Course.created();

            if(window.location.hash === '#editLessons')
            {
                Course.showEditLessons();
            }

        });

    </script>
@endsection