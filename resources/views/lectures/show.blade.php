@extends('layouts.app')

@section('content')
<form action="{{ route('lectures.complete', [$course, $lesson, $lecture]) }}" method="post">
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(count($lecture_user))
                    <div class="alert alert-success">
                        You completed this lecture on {{ $lecture_user[0]->completed_at->format('Y-m-d') }}
                    </div>
                @endif
                <div class="card" style="margin-bottom:30px;">
                    <div class="card-body">
                        <h5 style="margin-bottom:10px"><a href="{{ route('courses.show', $course) }}">{{ $course->title }} <em class="fa fa-angle-right"></em> {{ $lesson->title }}</a></h5>
                        <h2 class="no-mb">{{ $lecture->title }}</h2>
                    </div>
                    <div class="card-body">
                        {!! $lecture->body !!}
                    </div>
                    @if($lecture->type === 'Quiz')
                        <div class="card-body">
                            <?php $count = 1; ?>
                            @foreach($lecture->questions as $question)
                                <hr>
                                <div style="margin-bottom:20px;">
                                    <div class="small">Question {{ $count }}</div>
                                    <div>
                                        {!! $question->title !!}
                                    </div>
                                    <br>
                                    @foreach($question->answers as $answer)
                                        <div class="form-group">
                                            <input type="radio" name="q{{ $question->id }}" id="q{{ $question->id }}a{{ $answer->id }}"> {{ $answer->title }}
                                        </div>
                                    @endforeach
                                </div>
                                <?php $count += 1; ?>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        @if($lecture->type === 'Quiz')
                            <button type="submit" class="btn btn-success btn-lg">Submit Quiz</button>
                        @elseif($lecture->type === 'Download')
                            <button type="submit" class="btn btn-success btn-lg">Download</button>
                        @else
                            <button type="submit" class="btn btn-success btn-lg">Mark as Complete</button>
                        @endif
                    </div>
                </div>
                @if(count($lecture_user))
                    <div class="card">
                        <div class="card-header"><em class="fa fa-clock-o"></em> History</div>
                        <div class="card-body">
                            <ul>
                                @foreach($lecture_user as $record)
                                    <li> You completed this lecture on {{ $record->completed_at->format('Y-m-d') }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection
