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
                    <form action="{{ route('lectures.update', [$course, $lesson, $lecture]) }}" method="post" enctype="multipart/form-data">
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
                        <div id="articleGroup" class="type-group" style="display:none">
                            <div class="form-group">
                                <label for="articleBody">Article Body <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="article_body" id="articleBody" cols="30" rows="10">{{ old('article_body', $lecture->body) }}</textarea>
                            </div>
                        </div>
                        <div id="downloadGroup" class="type-group" style="display:none">
                            <div class="form-group">
                                <label for="downloadFile">Download File <small class="small text-danger">*</small></label><br>
                                @if(isset($lecture->file->id))
                                    <div class="alert alert-success">
                                        <em class="fa fa-check"></em> The file <b>{{ $lecture->file->full_name }}</b> is currently attached to this lesson.
                                    </div>
                                @endif
                                <input type="file" name="download_file" id="downloadFile">
                            </div>
                        </div>
                        <div id="quizGroup" class="type-group" style="display:none">
                            <div class="question-body">
                                @foreach($lecture->questions as $question)
                                    <div class="quiz-question-group" data-id="{{ $question->id }}">
                                        <div class="card bg-light mb-30">
                                            <div class="card-header">
                                                <input type="text" class="form-control question-title" name="question-titles[{{ $question->id }}]" value="{{ old('question-titles.' . $question->id, $question->title) }}" data-delete="false" data-id="{{ $question->id }}" autocomplete="off" required>
                                            </div>
                                            <div class="card-body answer-body" data-id="{{ $question->id }}">
                                                @foreach($question->answers as $answer)
                                                    <div class="form-row quiz-answer-group" data-id="{{ $answer->id }}">
                                                        <div class="col-md-2">
                                                            @if(old('correctAnswer.' . $question->id, $question->answer_id) == $answer->id)
                                                                <input type="radio" name="correctAnswer[{{ $question->id }}]" value="{{ $answer->id }}" class="correctAnswer" data-answer-id="{{ $answer->id }}" checked required> Correct
                                                            @else
                                                                <input type="radio" name="correctAnswer[{{ $question->id }}]" value="{{ $answer->id }}" class="correctAnswer" data-answer-id="{{ $answer->id }}" required> Correct
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control answer-title" name="answer-titles[{{ $answer->id }}]" value="{{ old('answer-titles.' . $answer->id, $answer->title) }}" data-delete="false" data-id="{{ $answer->id }}" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <button type="button" class="btn btn-default btn-sm deleteAnswerButton text-danger" data-id="{{ $answer->id }}" required><em class="fa fa-trash-o"></em> Delete Answer</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-default btn-sm addAnswerButton text-success" data-id="{{ $question->id }}" data-url="{{ route('answers.store', [$course, $lesson, $lecture, $question]) }}"><em class="fa fa-plus"></em> Add Answer</button>
                                                <button type="button" class="btn btn-default btn-sm deleteQuestionButton text-danger" data-id="{{ $question->id }}"><em class="fa fa-trash-o"></em> Delete Question</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <button type="button" class="btn btn-success addQuestionButton pull-left btn-lg"><em class="fa fa-plus"></em> Add Question</button>
                            </div>
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
@section('footer')
    <script type="text/javascript">

        var Lecture = {

            toggleLectureType: function(){

                var type = $('#lectureType').val();

                $('.type-group').hide();

                if(type === 'Article')
                {
                    $('#articleGroup').show();
                }
                else if(type === 'Quiz')
                {
                    $('#quizGroup').show();
                }
                else if(type === 'Download')
                {
                    $('#downloadGroup').show();
                }
                else
                {
                    alert('Invalid lecture type.');
                }

            },

            deleteQuizQuestion: function(obj){

                if(confirm('Are you sure you want to delete this question? Attached answers will also be deleted.'))
                {
                    var id = obj.target.getAttribute('data-id');

                    $('.quiz-question-group[data-id=' + id + ']').hide();
                    $('.question-title[data-id=' + id + ']').val('&DELETE');
                    $('.answer-body[data-id=' + id + ']').remove();
                }

            },

            deleteQuizAnswer: function(obj, isObjElement){

                if(confirm('Are you sure you want to delete this answer?'))
                {
                    if(isObjElement)
                    {
                        var id = obj.attr('data-id');
                        $('.quiz-answer-group[data-id=' + id + ']').remove();
                    }
                    else
                    {
                        var id = obj.target.getAttribute('data-id');
                        $('.quiz-answer-group[data-id=' + id + ']').hide();
                        $('.answer-title[data-id=' + id + ']').val('&DELETE');
                        $('.correctAnswer[data-answer-id=' + id + ']').removeAttr('checked');
                    }
                }

            },

            buildQuizQuestion: function(questionId, addQuestionUrl){

                var html = '<div class="quiz-question-group" data-id="' + questionId + '">';
                html += '<div class="card bg-light mb-30">';
                html += '<div class="card-header">';
                html += '<input type="text" class="form-control question-title" name="question-titles[' + questionId + ']" value="New Question Title" data-delete="false" data-id="' + questionId + '" autocomplete="off" required>';
                html += '</div>';
                html += '<div class="card-body answer-body" data-id="' + questionId + '">';
                html += '</div>';
                html += '<div class="card-footer">';
                html += '<button type="button" class="btn btn-default btn-sm addAnswerButton text-success mr-5" data-id="' + questionId + '" data-url="' + addQuestionUrl + '" onclick="Lecture.addQuizAnswer($(this), true)"><em class="fa fa-plus"></em> Add Answer</button>';
                html += '<button type="button" class="btn btn-default btn-sm deleteQuestionButton text-danger" data-id="' + questionId + '" onclick="Lecture.deleteQuizQuestion($(this), true)"><em class="fa fa-trash-o"></em> Delete Question</button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                return html;

            },

            buildQuizAnswer: function(questionId, answerId){

                var html = '<div class="form-row quiz-answer-group" data-id="' + answerId + '">';
                html += '<div class="col-md-2">';
                html += '<input type="radio" name="correctAnswer[' + questionId + ']" value="' + answerId + '" required class="correctAnswer" data-answer-id="' + answerId + '"> Correct';
                html += '</div>';
                html += '<div class="col-md-8">';
                html += '<div class="form-group">';
                html += '<input type="text" class="form-control answer-title" name="answer-titles[' + answerId + ']" value="New Answer" data-delete="false" data-id="' + answerId + '" autocomplete="off" required>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-2 text-right">';
                html += '<button type="button" class="btn btn-default btn-sm deleteAnswerButton text-danger" data-fresh="true" data-id="' + answerId + '" onclick="Lecture.deleteQuizAnswer($(this), true)"><em class="fa fa-trash-o"></em> Delete Answer</button>';
                html += '</div>';
                html += '</div>';

                return html;

            },

            addQuizQuestion: function(obj){

                $.post('{{ route('questions.store', [$course, $lesson, $lecture]) }}', {_token: '{{ csrf_token() }}'})
                    .done(function(question){

                        var buttonText = Lecture.buildQuizQuestion(question.id, question.url);
                        $('.question-body').append(buttonText);

                    })
                    .fail(function(){

                        alert('Something went wrong on the server.');

                    });

            },

            addQuizAnswer: function(obj, isObjElement, isFlatObj){

                if(isFlatObj)
                {
                    var url = obj.url;
                    var questionId = obj.id;
                }
                else if(isObjElement)
                {
                    var url = obj.attr('data-url');
                    var questionId = obj.attr('data-id');
                }
                else
                {
                    var url = obj.target.getAttribute('data-url');
                    var questionId = obj.target.getAttribute('data-id');
                }

                $.post(url, {_token: '{{ csrf_token() }}'})
                    .done(function(answerId){

                        var buttonText = Lecture.buildQuizAnswer(questionId, answerId);
                        $('.answer-body[data-id=' + questionId + ']').append(buttonText);

                    })
                    .fail(function(){

                        alert('Something went wrong on the server.');

                    });

            },

            created: function(){

                $('#lectureType').on('change', Lecture.toggleLectureType);

                $('.deleteQuestionButton').on('click', Lecture.deleteQuizQuestion.bind($(this)));
                $('.deleteAnswerButton').on('click', Lecture.deleteQuizAnswer.bind($(this)));

                $('.addAnswerButton').on('click', Lecture.addQuizAnswer.bind($(this)));
                $('.addQuestionButton').on('click', Lecture.addQuizQuestion.bind($(this)));

                Lecture.toggleLectureType();

            }

        };

        (function(){

            $(document).ready(function(){

                Lecture.created();

            });

        })();

    </script>
@endsection
