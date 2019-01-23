@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-30 mt-40">
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
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this lecture that will appear at the top of the page"></em>
                                <label for="lectureTitle">Lecture Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="lectureTitle" value="{{ old('title', $lecture->title) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this lecture"></em>
                                <label for="lectureSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="lectureSlug" value="{{ old('slug', $lecture->slug) }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The type of lecture that should be created"></em>
                                <label for="lectureType">Type <small class="small text-danger">*</small></label>
                                <select name="type" id="lectureType" class="form-control" required>
                                    @foreach($lecture_types as $lecture_type)
                                        @if(old('type', $lecture->type) === $lecture_type)
                                            <option value="{{ $lecture_type }}" selected>{{ $lecture_type }}</option>
                                        @else
                                            <option value="{{ $lecture_type }}">{{ $lecture_type }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The amount of time (in seconds) it will take the user to complete this lecture"></em>
                                <label for="lectureCompletionTime">Completion Time (in seconds) <small class="small text-danger">*</small></label>
                                <input type="number" class="form-control" name="completion_time" id="lectureCompletionTime" value="{{ old('completion_time', $lecture->completion_time) }}" required>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if this lecture should be included on the Library page and in search results"></em>
                                <label for="lectureShowInSearch">Show in Library? <small class="small text-danger">*</small></label>
                                <select name="show_in_search" id="lectureShowInSearch" class="form-control" required>
                                    @if(old('show_in_search', $lecture->show_in_search) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if the Completion History panel should be displayed on this lecture"></em>
                                <label for="showCompletionHistory">Show Completion History? <small class="small text-danger">*</small></label>
                                <select name="show_completion_history" id="showCompletionHistory" class="form-control">
                                    @if(old('show_completion_history', $lecture->show_completion_history) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if the Certified Users panel should be displayed on this lecture"></em>
                                <label for="showCertifiedUsers">Show Certified Users? <small class="small text-danger">*</small></label>
                                <select name="show_certified_users" id="showCertifiedUsers" class="form-control">
                                    @if(old('show_certified_users', $lecture->show_certified_users) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Determines if users should be allowed to print this lecture"></em>
                                <label for="lectureAllowPrinting">Allow Printing? <small class="small text-danger">*</small></label>
                                <select name="allow_print" id="lectureAllowPrinting" class="form-control" required>
                                    @if(old('allow_print', $lecture->allow_print) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group quizGroup type-group col-sm-6 col-md-4 col-lg-3" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Enable this option to allow users to see their score after completing this quiz"></em>
                                <label for="quizShowScore">Show Score</label>
                                <select name="quiz_show_score" id="quizShowScore" class="form-control">
                                    @if(old('quiz_show_score', $lecture->quiz_show_score) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group quizGroup type-group col-sm-6 col-md-4 col-lg-3" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Enable this option to allow users to see their answers after completing this quiz"></em>
                                <label for="quizShowAnswers">Show Answers</label>
                                <select name="quiz_show_answers" id="quizShowAnswers" class="form-control">
                                    @if(old('quiz_show_answers', $lecture->quiz_show_answers) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group quizGroup type-group col-sm-6 col-md-4 col-lg-3" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Enable this option to require users pass this quiz in order to mark this lecture as completed"></em>
                                <label for="quizPassToComplete">Require Passing Score</label>
                                <select name="quiz_pass_to_complete" id="quizPassToComplete" class="form-control">
                                    @if(old('quiz_pass_to_complete', $lecture->quiz_pass_to_complete) == '1')
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    @else
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group quizGroup type-group col-sm-6 col-md-4 col-lg-3" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The minimum percentage, out of 100, a user must score to pass this quiz"></em>
                                <label for="quizRequiredScore">Passing Score (percentage)</label>
                                <input type="number" class="form-control" id="quizRequiredScore" name="quiz_required_score" value="{{ old('quiz_required_score', $lecture->quiz_required_score) }}">
                            </div>
                            <div class="form-group col-sm-12 newLectureGroup">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="Select one or multiple skills the user will acquire after completing this course"></em>
                                <label>Associated Skills</label><br>
                                @foreach($skills as $skill)
                                    <input type="checkbox" name="associated_skills_{{ $skill->id }}" {{ old('associated_skills_' . $skill->id, $lecture->hasSkill($skill->id) ? 'on' : '') === 'on' ? 'checked' : '' }}> {{ $skill->title }} <br>
                                @endforeach
                            </div>
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A description of the content, or the main content of this lecture"></em>
                                <label for="articleBody">Body <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="article_body" id="articleBody" cols="30" rows="10">{{ old('article_body', $lecture->body) }}</textarea>
                            </div>
                            <div class="form-group downloadGroup type-group col-sm-12" style="display:none">
                                <label for="downloadFile">Download File <small class="small text-danger">*</small></label><br>
                                @if(isset($lecture->file->id))
                                    <div class="alert alert-success">
                                        <em class="fa fa-check"></em> The file <b>{{ $lecture->file->full_name }}</b> is currently attached to this lesson.
                                    </div>
                                @endif
                                <input type="file" name="download_file" id="downloadFile">
                            </div>
                            <div class="form-group quizGroup type-group col-sm-12" style="display:none">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The questions associated with this quiz"></em>
                                <label for="">Quiz Questions</label><br>
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
                            <div class="form-group col-sm-12 text-right">
                                <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-warning btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
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
                    $('.articleGroup').show();
                }
                else if(type === 'Quiz')
                {
                    $('.quizGroup').show();
                }
                else if(type === 'Download')
                {
                    $('.downloadGroup').show();
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

                tinymce.init({
                    selector: '[name=article_body]',
                    plugins: 'print preview powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
                    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                    image_advtab: true,
                });

            }

        };

        (function(){

            $(document).ready(function(){

                Lecture.created();

            });

        })();

    </script>
@endsection
