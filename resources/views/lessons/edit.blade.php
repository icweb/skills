@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-30 mt-40">
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
                        <input type="hidden" name="order">
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this lesson that will appear at the top of the panel"></em>
                                <label for="lessonTitle">Lesson Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title', $lesson->title) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this lesson"></em>
                                <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug', $lesson->slug) }}" required autocomplete="off">
                            </div>
                            @if($lesson->assignedLectures()->count() > 1)
                                <div class="form-group col-sm-12">
                                    <label for="">
                                        Lecture Order<br>
                                        <small>Drag and drop the lectures below to determine the order they will be displayed on the page</small>
                                    </label>
                                    <ol class="lectureList">
                                        @foreach($lesson->assignedLectures()->orderBy('position', 'asc')->get() as $item)
                                            <li data-id="{{ $item->lecture_id }}" class="select-cursor">{{ $item->lecture->title }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                            <div class="text-right col-sm-12">
                                <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-warning btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
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
@section('footer')
    <script type="text/javascript">
        var EditLesson = {

            created: function(){

                var group = $("ol.lectureList").sortable({
                    group: 'serialization',
                    delay: 0,
                    onDrop: function ($item, container, _super) {

                        var data = group.sortable("serialize").get();

                        $('[name=order]').val(JSON.stringify(data));

                        _super($item, container);
                    }
                });
            }

        };

        $(document).ready(function(){

            EditLesson.created();

        });
    </script>
@endsection
