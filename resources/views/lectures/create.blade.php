@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
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
                        <div class="form-group">
                            <label for="">Creation Type <small class="small text-danger">*</small></label><br>
                            <input type="radio" name="creation" value="new" checked> Create New Lecture <br>
                            <input type="radio" name="creation" value="existing" {{ old('creation') === 'existing' ? 'checked' : '' }}> Use Existing Lecture <br>
                        </div>
                        <div id="existingLectureGroup" style="display:none">
                            <div class="form-group">
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
                        </div>
                        <div id="newLectureGroup">
                            <div class="form-group">
                                <label for="lectureTitle">Lecture Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lectureTitle" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="lectureSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lectureSlug" value="{{ old('slug') }}">
                            </div>
                            <div class="form-group">
                                <label for="lectureCompletionTime">Completion Time <small class="small text-danger">*</small></label>
                                <input type="number" class="form-control" name="completion_time" id="lectureCompletionTime" value="{{ old('completion_time') }}">
                            </div>
                            <div class="form-group">
                                <label>Associated Skills</label><br>
                                @foreach($skills as $skill)
                                    <input type="checkbox" name="associated_skills_{{ $skill->id }}" {{ old('associated_skills_' . $skill->id) === 'on' ? 'checked' : '' }}> {{ $skill->title }} <br>
                                @endforeach
                            </div>
                            <div class="form-group">
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
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save & Continue</button>
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

                var value = $('[name="creation"]:checked').val();

                if(value === 'new')
                {
                    $('#existingLectureGroup').hide();
                    $('#newLectureGroup').show();
                }
                else
                {
                    $('#existingLectureGroup').show();
                    $('#newLectureGroup').hide();
                }

            },

            created: function(){

                $('[name="creation"]').on('change', Lecture.toggleCreationField);

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
