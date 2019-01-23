@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-40">
                <div class="card-header bg-success text-white">Add Lecture</div>
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
                    <form action="{{ route('lectures.store', [$course, $lesson]) }}" method="post">
                        @csrf
                        <div class="alert alert-warning text-left">You'll be able to add content on the next page</div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Select if you want to create a new lecture, or link an existing lecture"></em>
                                <label for="">Creation Type <small class="small text-danger">*</small></label><br>
                                <input type="radio" name="creation_type" value="new" checked required> Create New Lecture <br>
                                <input type="radio" name="creation_type" value="existing" {{ old('creation_type') === 'existing' ? 'checked' : '' }} required> Use Existing Lecture <br>
                            </div>
                            <div class="form-group existingLectureGroup col-sm-12" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Select an existing lecture to add to this lesson"></em>
                                <label for="existingLecture">Existing Lesson <small class="small text-danger">*</small></label>
                                <select name="existing_lecture" id="existingLecture" class="form-control">
                                    <option value="" selected disabled>Select a Lesson</option>
                                    @foreach($existing_lectures as $existing_lecture)
                                        @if(old('existing_lecture') == $existing_lecture->id)
                                            <option value="{{ $existing_lecture->id }}" selected>{{ $existing_lecture->title }}</option>
                                        @else
                                            <option value="{{ $existing_lecture->id }}">{{ $existing_lecture->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this lecture that will appear at the top of the page"></em>
                                <label for="lectureTitle">Lecture Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lectureTitle" value="{{ old('title') }}" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this lecture"></em>
                                <label for="lectureSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lectureSlug" value="{{ old('slug') }}" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The type of lecture that should be created"></em>
                                <label for="lectureType">Type <small class="small text-danger">*</small></label>
                                <select name="type" id="lectureType" class="form-control">
                                    @foreach($lecture_types as $lecture_type)
                                        @if(old('type') === $lecture_type)
                                            <option value="{{ $lecture_type }}" selected>{{ $lecture_type }}</option>
                                        @else
                                            <option value="{{ $lecture_type }}">{{ $lecture_type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The amount of time (in seconds) it will take the user to complete this lecture"></em>
                                <label for="lectureCompletionTime">Completion Time (in seconds) <small class="small text-danger">*</small></label>
                                <input type="number" class="form-control" name="completion_time" id="lectureCompletionTime" value="{{ old('completion_time', 0) }}" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if this lecture should be included on the Library page and in search results"></em>
                                <label for="lectureShowInSearch">Show in Library? <small class="small text-danger">*</small></label>
                                <select name="show_in_search" id="lectureShowInSearch" class="form-control">
                                    @if(old('show_in_search', '1') == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if the Completion History panel should be displayed on this lecture"></em>
                                <label for="showCompletionHistory">Show Completion History? <small class="small text-danger">*</small></label>
                                <select name="show_completion_history" id="showCompletionHistory" class="form-control">
                                    @if(old('show_completion_history', '1') == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if the Certified Users panel should be displayed on this lecture"></em>
                                <label for="showCertifiedUsers">Show Certified Users? <small class="small text-danger">*</small></label>
                                <select name="show_certified_users" id="showCertifiedUsers" class="form-control">
                                    @if(old('show_certified_users', '1') == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if users should be allowed to print this lecture"></em>
                                <label for="lectureAllowPrinting">Allow Printing? <small class="small text-danger">*</small></label>
                                <select name="allow_print" id="lectureAllowPrinting" class="form-control">
                                    @if(old('allow_print', '1') == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-12 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Select one or multiple skills the user will acquire after completing this course"></em>
                                <label>Associated Skills</label><br>
                                @foreach($skills as $skill)
                                    <input type="checkbox" name="associated_skills_{{ $skill->id }}" {{ old('associated_skills_' . $skill->id) === 'on' ? 'checked' : '' }}> {{ $skill->title }} <br>
                                @endforeach
                            </div>
                            <div class="text-right col-sm-12">
                                <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save & Continue</button>
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

        var Lecture = {

            toggleCreationField: function(){

                var value = $('[name="creation_type"]:checked').val();

                if(value === 'new')
                {
                    $('.existingLectureGroup').hide();
                    $('.newLectureGroup').show();
                }
                else
                {
                    $('.existingLectureGroup').show();
                    $('.newLectureGroup').hide();
                }

            },

            created: function(){

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

                $('[name="creation_type"]').on('change', Lecture.toggleCreationField);

                Lecture.toggleCreationField();

            }

        };

        (function(){

            $(document).ready(function(){

                Lecture.created();

            });

        })();

    </script>
@endsection
