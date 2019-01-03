@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-30">
                <div class="card-header bg-warning">Edit Lecture</div>
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
                    <form action="{{ route('lectures.update', [$course, $lesson, $lecture]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="lectureTitle">Lecture Title <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="lectureTitle" value="{{ old('title', $lecture->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="lectureSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="lectureSlug" value="{{ old('slug', $lecture->slug) }}">
                        </div>
                        <div class="form-group">
                            <label for="lectureCompletionTime">Completion Time <small class="small text-danger">*</small></label>
                            <input type="number" class="form-control" name="completion_time" id="lectureCompletionTime" value="{{ old('completion_time', $lecture->completion_time) }}">
                        </div>
                        <div class="form-group">
                            <label for="lectureType">Type <small class="small text-danger">*</small></label>
                            <select name="type" id="lectureType" class="form-control">
                                @foreach($lecture_types as $lecture_type)
                                    @if(old('type', $lecture->type) === $lecture_type)
                                        <option value="{{ $lecture_type }}" selected>{{ $lecture_type }}</option>
                                    @else
                                        <option value="{{ $lecture_type }}">{{ $lecture_type }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-warning btn-lg"><em class="fa fa-save"></em> Save</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('partials.panel-delete', [
                'title' => 'Lecture',
                'body'  => 'You can delete this lecture from only this lesson, or from all lessons in all courses.',
                'modal' => 'deleteLectureModal'
            ])
        </div>
    </div>
</div>
@include('partials.modal-delete', [
    'title'     => 'Lecture',
    'id'        => 'deleteLectureModal',
    'form'      => route('lectures.delete', [$course, $lesson, $lecture]),
    'message'   => 'Do you want to delete this lecture from only this lesson, or from all lessons in all courses?',
    'table'      => true,
    'table_data' => [
        'soft' => [
            'title'     => 'This Lesson',
            'message'   => 'This is the safest option. Selecting this action will remove the lecture from this lesson, but keep it available for reassignment.'
        ],
        'hard' => [
            'title'     => 'All Lessons',
            'message'   => 'Selecting this action will remove the lecture from all lessons and courses.'
        ]
    ]
])
@endsection
