@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" style="margin-bottom:30px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 hide-on-lessons-edit">
                            <button type="button" class="btn btn-block btn-default text-primary" id="editLessonsButton">
                                <em class="fa fa-edit fa-2x"></em><br>
                                <h5 class="mb-0">Edit</h5>
                            </button>
                        </div>
                        <div class="col-sm-4 show-on-lessons-edit">
                            <button type="button" class="btn btn-block btn-default text-primary" id="previewLessonsButton">
                                <em class="fa fa-eye fa-2x"></em><br>
                                <h5 class="mb-0">Preview</h5>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-block btn-default" id="manageCourseButton">
                                <em class="fa fa-users fa-2x"></em><br>
                                <h5 class="mb-0">Manage</h5>
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-block btn-default text-danger" id="deleteCourseButton">
                                <em class="fa fa-trash-o fa-2x"></em><br>
                                <h5 class="mb-0">Delete</h5>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @if($course->isCompleted() && count($course->assignedLessons) > 0)
                <div class="card bg-success text-white mb-30 hide-on-lessons-edit hide-on-course-edit">
                    <div class="card-body">
                        <h4><em class="fa fa-check"></em> Course Completed</h4>
                        You completed this course
                    </div>
                </div>
            @endif
            <div class="row mb-60">
                <div class="col-md-8">
                    <div class="card mb-10">
                        <div class="card-body" style="min-height: 200px">
                            <a href="{{ route('courses.edit', [$course]) }}" class="btn btn-warning btn-sm pull-right show-on-lessons-edit"><em class="fa fa-pencil"></em> Edit</a>
                            <h2 style="margin-bottom:10px;">{{ $course->title }}</h2>
                            <p class="mb-0">{{ $course->long_description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-10">
                        <div class="card-body" style="min-height: 200px">
                            <div style="margin-bottom:10px;" class="small">Time to complete this course:</div>
                            <div class="card-completion">{{ $course->completionTime() }}</div>
                            <br>
                            <div style="margin-bottom:10px;" class="small">Skills you will earn in this course:</div>
                            @include('partials.section-skills', ['skills' => $course->skills()])
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-11">
            <div class="mb-30 show-on-lessons-edit">
                <a href="{{ route('lessons.create', [$course]) }}" class="btn btn-success"><em class="fa fa-plus"></em> Add Lesson</a>
            </div>
            @foreach($course->assignedLessons as $assigned_lesson)
                @include('partials.panel-lesson', ['lesson' => $assigned_lesson->lesson])
            @endforeach
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

        (function(){

           $(document).ready(function(){

               Course.created();

               if(window.location.hash === '#editLessons')
               {
                   Course.showEditLessons();
               }

           });

        })();

    </script>
@endsection