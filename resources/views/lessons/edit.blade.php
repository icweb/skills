@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning">Edit Lesson</div>
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
                        <form action="{{ route('lessons.update', [$course, $lesson]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="lessonTitle">Lesson Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title', $lesson->title) }}">
                            </div>
                            <div class="form-group">
                                <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug', $lesson->slug) }}">
                            </div>
                            <div class="form-group">
                                <label>Associated Skills</label><br>
                                @foreach($skills as $skill)
                                    @if(
                                    (old('associated_skills_' . $skill->id) === 'on')
                                    || $lesson->hasSkill($skill->id)
                                    )
                                        <input type="checkbox" name="associated_skills_{{ $skill->id }}" checked> {{ $skill->title }} <br>
                                    @else
                                        <input type="checkbox" name="associated_skills_{{ $skill->id }}"> {{ $skill->title }} <br>
                                    @endif

                                @endforeach
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-danger btn-lg pull-left" id="deleteLessonButton" data-toggle="modal" data-target="#deleteLessonsModal"><em class="fa fa-trash-o"></em> Delete</button>
                                <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="deleteLessonsModal" tabindex="-1" role="dialog">
        <form action="{{ route('lessons.delete', [$course, $lesson]) }}" method="post">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-top: 4px solid red !important">
                <div class="modal-header">
                    <h5>Confirm Delete Lesson</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="alert alert-danger">
                        Do you want to delete this lesson from only this course, or from all courses?
                    </div>
                    <table class="table mb-0">
                        <tr>
                            <td style="width: 130px;">
                                <input type="radio" name="delete_type" value="soft" checked>
                                <b>This Course</b>
                            </td>
                            <td>
                                This is the safest option. Selecting this action will remove the lesson from this course, but keep it available for reassignment.<br>
                                <em class="fa fa-check text-success"></em> <b class="text-success">If you are unsure, select this option.</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" name="delete_type" value="hard">
                                <b>All Courses</b>
                            </td>
                            <td>
                                Selecting this action will remove the lesson from all courses.<br>
                                <em class="fa fa-warning text-danger"></em> <b class="text-danger">This is destructive and cannot be reversed.</b>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
