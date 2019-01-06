@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">Add Lesson</div>
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
                    <form action="{{ route('lessons.store', [$course]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Creation Type <small class="small text-danger">*</small></label><br>
                            <input type="radio" name="creation" value="new" checked> Create New Lesson <br>
                            <input type="radio" name="creation" value="existing" {{ old('creation') === 'existing' ? 'checked' : '' }}> Use Existing Lesson <br>
                        </div>
                        <div id="existingLessonGroup" style="display:none">
                            <div class="form-group">
                                <label for="existingLesson">Existing Lesson <small class="small text-danger">*</small></label>
                                <select name="existing_lesson" id="existingLesson" class="form-control">
                                    <option value="" selected disabled>Select a Lesson</option>
                                    @foreach($existing_lessons as $existing_lesson)
                                        @if(old('existing_lesson') == $existing_lesson->id)
                                            <option value="{{ $existing_lesson->id }}" selected>{{ $existing_lesson->title }}</option>
                                        @else
                                            <option value="{{ $existing_lesson->id }}">{{ $existing_lesson->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="newLessonGroup">
                            <div class="form-group">
                                <label for="lessonTitle">Lesson Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug') }}">
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Lesson = {

            toggleCreationField: function(){

                var value = $('[name="creation"]:checked').val();

                if(value === 'new')
                {
                    $('#existingLessonGroup').hide();
                    $('#newLessonGroup').show();
                }
                else
                {
                    $('#existingLessonGroup').show();
                    $('#newLessonGroup').hide();
                }

            },

            created: function(){

                $('[name="creation"]').on('change', Lesson.toggleCreationField);

                Lesson.toggleCreationField();

            }

        };

        (function(){

            $(document).ready(function(){

                Lesson.created();

            });

        })();

    </script>
@endsection
