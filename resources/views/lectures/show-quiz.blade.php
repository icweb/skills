@if(count($lecture->questions))
    <div class="card mb-30">
        <div class="card-body">
            @if($show_answers)
                <a href="{{ $next ? route('lectures.show', [$course, $lesson, $next]) : route('courses.show', $course) }}" class="btn btn-success btn-lg pull-right">Next <em class="fa fa-chevron-right"></em></a>
            @endif
            @if($lecture->quiz_pass_to_complete)
                <span class="text-primary">
                <b><em class="fa fa-asterisk"></em> Score to Pass: </b> {{ $lecture->quiz_required_score }}% or higher<br>
            </span>
            @endif
            @if(count($lecture->quizScore))
                @if(!$lecture->quiz_show_score)
                    <b><em class="fa fa-asterisk"></em> Completed on: </b> {{ $lecture->quizScore()->orderBy('id', 'desc')->first()['created_at']->format('m/d/Y') }}
                @elseif($lecture->quizScore()->orderBy('id', 'desc')->first()['status'] === 'Pass')
                    <span class="text-success">
                     <b><em class="fa fa-check"></em> Score Received: </b> {{ $lecture->quizScore()->orderBy('id', 'desc')->first()['score'] }}% on {{ $lecture->quizScore()->orderBy('id', 'desc')->first()['created_at']->format('m/d/Y') }} ({{ $lecture->quizScore()->orderBy('id', 'desc')->first()['status'] }})
                </span>
                @else
                    <span class="text-danger">
                     <b><em class="fa fa-times"></em> Score Received: </b> {{ $lecture->quizScore()->orderBy('id', 'desc')->first()['score'] }}% on {{ $lecture->quizScore()->orderBy('id', 'desc')->first()['created_at']->format('m/d/Y') }} ({{ $lecture->quizScore()->orderBy('id', 'desc')->first()['status'] }})
                </span>
                @endif
            @endif
        </div>
    </div>

    @if($show_answers)
        <div class="card mb-30">
            <div class="card-body articleBodyHtml">
                <?php $count = 1; ?>
                @foreach($lecture->questions as $question)
                    <div style="margin-bottom:{{ $count === count($lecture->questions) ? '0' : '20px' }};">
                        <div class="small">Question {{ $count }}</div>
                        <div class="mb-10">
                            {!! $question->title !!}
                        </div>
                        @if($answers[$question->id]['id'] === $question->rightAnswer->id)
                            <div class="text-success">
                                <table class="table mb-0" style="width:100%">
                                    <tr>
                                        <td style="width: 150px;"><b>You Picked</b></td>
                                        <td>{{ $answers[$question->id]['title'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Correct Answer</b></td>
                                        <td>{{ $question->rightAnswer->title }}</td>
                                    </tr>
                                </table>
                            </div>
                        @else
                            <div class="text-danger">
                                <table class="table mb-0" style="width:100%">
                                    <tr>
                                        <td style="width: 150px;"><b>You Picked</b></td>
                                        <td>{{ $answers[$question->id]['title'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><b>Correct Answer</b></td>
                                        <td>{{ $question->rightAnswer->title }}</td>
                                    </tr>
                                </table>
                            </div>
                        @endif
                        <?php $count2 = 1; ?>
                    </div>
                    <?php $count += 1; ?>
                @endforeach
            </div>
        </div>
    @else
        <div class="card mb-30">
            <div class="card-body articleBodyHtml">
                {!! nl2br($body) !!}
            </div>
        </div>
        <form action="{{ isset($course) ? route('lectures.complete', [$course, $lesson, $lecture]) : '#' }}" method="post">
            @csrf
            <div class="card mb-30">
                <div class="card-body">
                    <?php $count = 1; ?>
                    @foreach($lecture->questions as $question)
                        @if($count > 1)
                            <hr>
                        @endif
                        <div style="margin-bottom:{{ $count === count($lecture->questions) ? '0' : '20px' }};">
                            <div class="small">Question {{ $count }}</div>
                            <div class="mb-0">
                                {!! $question->title !!}
                            </div>
                            <div class="small mb-10"><em class="fa fa-info-circle"></em> Select one answer below.</div>
                            <?php $count2 = 1; ?>
                            @foreach($question->answers as $answer)
                                <div class="form-group">
                                    <b>{{ $count2 }}.</b>
                                    @if(isset($course))
                                        <input type="radio" name="qq_{{ $question->id }}" id="qq_{{ $question->id }}a{{ $answer->id }}" value="{{ $answer->id }}">
                                    @endif
                                    {{ $answer->title }}
                                </div>
                                <?php $count2 += 1; ?>
                            @endforeach
                        </div>
                        <?php $count += 1; ?>
                    @endforeach
                </div>
            </div>
            <div class="mb-30 d-print-none">
                <button type="submit" class="btn btn-success btn-lg btn-block" onclick="return confirm('Are you sure?')"><em class="fa fa-check"></em> Submit Quiz</button>
            </div>
        </form>
    @endif
@else
    <div class="alert alert-warning">
        This quiz does not have any questions.
    </div>
@endif