@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card hide-on-lessons-edit hide-on-course-edit" style="margin-bottom:30px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-default text-primary" id="editCourseButton">
                                <em class="fa fa-edit fa-2x"></em><br>
                                <h5 class="mb-0">Course</h5>
                            </button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-default text-primary" id="editLessonsButton">
                                <em class="fa fa-edit fa-2x"></em><br>
                                <h5 class="mb-0">Lessons</h5>
                            </button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-default" id="manageCourseButton">
                                <em class="fa fa-users fa-2x"></em><br>
                                <h5 class="mb-0">Manage</h5>
                            </button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-default text-danger" id="deleteCourseButton">
                                <em class="fa fa-trash-o fa-2x"></em><br>
                                <h5 class="mb-0">Delete</h5>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning show-on-lessons-edit">
                <h4><b><em class="fa fa-pencil"></em> Lessons Edit Mode</b></h4>
                <p class="mb-10">You are editing the <b>{{ $course->title }}</b> course lessons as <b>{{ auth()->user()->name }}</b>. Your changes wil be saved automatically.</p>
                <button type="button" id="exitEditLessonsButton" class="btn btn-warning btn-lg"><em class="fa fa-times"></em> Exit Edit Mode</button>
            </div>
            <div class="alert alert-warning show-on-course-edit">
                <h4><b><em class="fa fa-pencil"></em> Course Edit Mode</b></h4>
                <p class="mb-10">You are editing the <b>{{ $course->title }}</b> course as <b>{{ auth()->user()->name }}</b>. Press save at the bottom of the page to save your changes.</p>
                <button type="button" id="exitEditCourseButton" class="btn btn-warning btn-lg"><em class="fa fa-times"></em> Exit Edit Mode</button>
            </div>
            @if($course->isCompleted() && count($course->assignedLessons) > 0)
                <div class="card bg-success text-white mb-30 hide-on-lessons-edit hide-on-course-edit">
                    <div class="card-body">
                        <h4><em class="fa fa-check"></em> Course Completed</h4>
                        You completed this course
                    </div>
                </div>
            @endif
            <div class="card hide-on-course-edit hide-on-lessons-edit" style="margin-bottom:30px;">
                <div class="card-body">
                    <h2 style="margin-bottom:10px;">{{ $course->title }}</h2>
                    <p>{{ $course->long_description }}</p>
                    <div>
                        <div style="margin-bottom:10px;" class="small">Skills you will earn in this course:</div>
                        @foreach($course->skills() as $skill)
                            <span style="color:{{ $skill->color }};margin-right:5px;"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card show-on-course-edit">
                @if ($errors->any())
                    <div class="alert alert-danger" style="border-radius: 0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('courses.update', [$course]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="courseTitle">Course Title <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="courseTitle" value="{{ old('title', $course->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="courseSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="courseSlug" value="{{ old('slug', $course->slug) }}">
                        </div>
                        <div class="form-group">
                            <label for="courseRecertifyInterval">Recertify Interval (in days) <small class="small text-danger">*</small></label>
                            <input type="number" class="form-control" name="recertify_interval" id="courseRecertifyInterval" value="{{ old('recertify_interval', $course->recertify_interval) }}">
                        </div>
                        <div class="form-group">
                            <label for="courseShortDescription">Short Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="short_description" id="courseShortDescription" cols="30" rows="3">{{ old('short_description', $course->short_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="courseLongDescription">Long Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="long_description" id="courseLongDescription" cols="30" rows="10">{{ old('long_description', $course->long_description) }}</textarea>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hide-on-course-edit">
                <div class="mb-30 show-on-lessons-edit">
                    <a href="{{ route('lessons.create', [$course]) }}" class="btn btn-success"><em class="fa fa-plus"></em> Add Lesson</a>
                </div>
                @foreach($course->assignedLessons as $lesson)
                    <div class="card mb-40">
                        @if($lesson->lesson->isCompleted(false) && count($lesson->lesson->assignedLectures) > 0)
                            <div class="card-header bg-success text-white">
                                <em class="fa fa-check"></em> {{ $lesson->lesson->title }}
                                <span class="pull-right">
                                Completed
                            </span>
                            </div>
                        @else
                            <div class="card-header">
                                {{ $lesson->lesson->title }}
                            </div>
                        @endif
                        <div>
                            <table class="table no-mb">
                                <tbody>
                                @foreach($lesson->lesson->assignedLectures as $lecture)
                                    <tr>
                                        <td style="width:50px;">
                                            @if($lecture->lecture->type === 'Quiz')
                                                <em class="fa fa-play-circle"></em>
                                            @elseif($lecture->lecture->type === 'Download')
                                                <em class="fa fa-download"></em>
                                            @elseif($lecture->lecture->type === 'Video')
                                                <em class="fa fa-video-camera"></em>
                                            @else
                                                <em class="fa fa-file-o"></em>
                                            @endif
                                        </td>
                                        <td style="width:100px;" class="{{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">
                                            {{ $lecture->lecture->type }}
                                        </td>
                                        <td class="{{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">
                                            <a href="{{ route('lectures.show', [$course, $lesson->lesson, $lecture->lecture]) }}">{{ $lecture->lecture->title }}</a>
                                        </td>
                                        <td class="text-right">
                                            @if(count($lecture->lecture->completionHistory()) > 0)

                                                @if(strtotime($lecture->lecture->completionHistory()[0]->recertify_at) > time())
                                                    <span class="text-danger">
                                                            Recertify due {{ $lecture->lecture->completionHistory()[0]->recertify_at->format('Y-m-d') }}
                                                        </span>
                                                @else
                                                    <span class="text-success">
                                                            Completed {{ $lecture->lecture->completionHistory()[0]->completed_at->format('Y-m-d') }}
                                                        </span>
                                                @endif

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body show-on-lessons-edit">
                            <a href="{{ route('lectures.create', [$course, $lesson->lesson]) }}" class="btn btn-success"><em class="fa fa-plus"></em> Add Lecture</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Course = {

            showEditCourse: function(){

                window.location.hash = 'editCourse';
                $('.hide-on-course-edit').hide();
                $('.show-on-course-edit').show();

            },

            hideEditCourse: function(){

                window.location.hash = '';
                $('.hide-on-course-edit').show();
                $('.show-on-course-edit').hide();

            },

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

                $('#editCourseButton').on('click', Course.showEditCourse);
                $('#exitEditCourseButton').on('click', Course.hideEditCourse);

                $('#editLessonsButton').on('click', Course.showEditLessons);
                $('#exitEditLessonsButton').on('click', Course.hideEditLessons);

            }

        };

        (function(){

           $(document).ready(function(){

               Course.created();

               if(window.location.hash === '#editCourse')
               {
                   Course.showEditCourse();
               }
               else if(window.location.hash === '#editLessons')
               {
                   Course.showEditLessons();
               }

           });

        })();

    </script>
@endsection