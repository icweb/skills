@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-40">
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
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Crete a new lesson, or add an existing lesson"></em>
                                <label for="">Creation Type <small class="small text-danger">*</small></label><br>
                                <input type="radio" name="creation_type" value="new" checked required> Create New Lesson <br>
                                <input type="radio" name="creation_type" value="existing" {{ old('creation_type') === 'existing' ? 'checked' : '' }} required> Use Existing Lesson <br>
                            </div>
                            <div class="form-group col-sm-12 existingLessonGroup" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Select an existing lesson to add to this course"></em>
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
                            <div class="form-group col-sm-12 newLessonGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this lesson that will appear at the top of the panel"></em>
                                <label for="lessonTitle">Lesson Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title') }}" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-12 newLessonGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this lesson"></em>
                                <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug') }}" autocomplete="off">
                            </div>
                            <div class="text-right col-sm-12">
                                <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
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

                var value = $('[name="creation_type"]:checked').val();

                if(value === 'new')
                {
                    $('.existingLessonGroup').hide();
                    $('.newLessonGroup').show();
                }
                else
                {
                    $('.existingLessonGroup').show();
                    $('.newLessonGroup').hide();
                }

            },

            created: function(){

                $('[name="creation_type"]').on('change', Lesson.toggleCreationField);

                Lesson.toggleCreationField();

                $('[name=title]').on('change', function(){

                    if($('[name=slug]').val() === '')
                    {
                        $('[name=slug]').val($('[name=title]').val());
                    }

                });

                $('[name=slug]').on('keyup', function(){

                    var slugify = App.slugify($('[name=slug]').val());

                    $('[name=slug]').val(slugify);

                });

            }

        };

        (function(){

            $(document).ready(function(){

                Lesson.created();

            });

        })();

    </script>
@endsection
