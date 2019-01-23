@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-40 mb-30">
                <div class="card-header bg-warning">Edit Course Details</div>
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
                        <input type="hidden" name="order">
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this course that will appear at the top of the page"></em>
                                <label for="courseTitle">Course Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="courseTitle" value="{{ old('title', $course->title) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this course"></em>
                                <label for="courseSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="courseSlug" value="{{ old('slug', $course->slug) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The color that will be used as the background and accent color for this course"></em>
                                <label for="courseColor">Color <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="color" id="courseColor" value="{{ old('color', $course->color) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The interval (in days) in which a user is required to complete this course again"></em>
                                <label for="courseRecertifyInterval">Recertify Interval (in days) <small class="small text-danger">*</small></label>
                                <input type="number" class="form-control" name="recertify_interval" id="courseRecertifyInterval" value="{{ old('recertify_interval', $course->recertify_interval) }}" required autocomplete="off">
                            </div>
                            @if($course->assignedLessons()->count() > 1)
                                <div class="form-group col-sm-12">
                                    <label for="">
                                        Lesson Order<br>
                                        <small>Drag and drop the lessons below to determine the order they will be displayed on that page</small>
                                    </label>
                                    <ol class="lessonList">
                                        @foreach($course->assignedLessons()->orderBy('position', 'asc')->get() as $item)
                                            <li data-id="{{ $item->lesson_id }}" class="select-cursor">{{ $item->lesson->title }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A short description under 250 characters that will be displayed on the course preview"></em>
                                <span class="pull-right small"><span id="sd-count"></span> left</span>
                                <label for="courseShortDescription">Short Description <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="short_description" id="courseShortDescription" cols="30" rows="3" required maxlength="250">{{ old('short_description', $course->short_description) }}</textarea>
                            </div>
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A long description that will be displayed on under the About This Course section"></em>
                                <label for="courseLongDescription">Long Description <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="long_description" id="courseLongDescription" cols="30" rows="10" required>{{ old('long_description', $course->long_description) }}</textarea>
                            </div>
                            <div class="text-right col-sm-12">
                                <a href="{{ route('courses.show', $course) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-warning btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('partials.panel-delete', [
            'title' => 'Course',
            'body'  => 'Delete this course and all associated data.',
            'modal' => 'deleteCourseModal'
        ])
        </div>
    </div>
</div>
@include('partials.modal-delete', [
'title'     => 'Course',
'id'        => 'deleteCourseModal',
'form'      => route('courses.delete', [$course]),
'message'   => 'Are you sure you want to delete this course and all associated data?',
'table'      => false,
'table_data' => []
])
@endsection

@section('footer')
    <script type="text/javascript">
        var EditCourse = {

            created: function(){

                var group = $("ol.lessonList").sortable({
                    group: 'serialization',
                    delay: 0,
                    onDrop: function ($item, container, _super) {

                        var data = group.sortable("serialize").get();

                        $('[name=order]').val(JSON.stringify(data));

                        _super($item, container);
                    }
                });

                tinymce.init({
                    selector: '[name=long_description]',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link print preview textcolor',
                        'searchreplace visualblocks code fullscreen',
                        'table contextmenu paste code help wordcount'
                    ],
                    toolbar: 'undo redo |  formatselect | bold italic  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat',
                });

                $('[name=color]').colorpicker();

                App.charactersLeft('[name=short_description]', 250, '#sd-count');
            }

        };

        $(document).ready(function(){

            EditCourse.created();

        });
    </script>
@endsection

