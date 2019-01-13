@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-30">
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
                            <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title', $lesson->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug', $lesson->slug) }}" required>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-warning btn-lg"><em class="fa fa-save"></em> Save</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('partials.panel-delete', [
                'title' => 'Lesson',
                'body'  => 'You can delete this lesson from only this course, or from all courses.',
                'modal' => 'deleteLessonsModal'
            ])
        </div>
    </div>
</div>
@include('partials.modal-delete', [
    'title'     => 'Lesson',
    'id'        => 'deleteLessonsModal',
    'form'      => route('lessons.delete', [$course, $lesson]),
    'message'   => 'Do you want to delete this lesson from only this course, or from all courses?',
    'table'      => true,
    'table_data' => [
        'soft' => [
            'title'     => 'This Course',
            'message'   => 'This is the safest option. Selecting this action will remove the lesson from this course, but keep it available for reassignment.'
        ],
        'hard' => [
            'title'     => 'All Courses',
            'message'   => 'Selecting this action will remove the lesson from all courses.'
        ]
    ]
])
@endsection
