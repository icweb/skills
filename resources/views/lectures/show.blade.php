@extends('layouts.app')

@section('content')
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
                    <h2 style="margin-bottom:0">{{ $lecture->title }}</h2>
                </div>
                <div class="card-body">
                    {!! $lecture->body !!}
                </div>
                <div class="card-body">
                    <form action="{{ route('lectures.complete', [$course, $lesson, $lecture]) }}" method="post">
                        @csrf
                        @if($lecture->type === 'Quiz')
                            <button type="submit" class="btn btn-success btn-lg">Submit Quiz</button>
                        @elseif($lecture->type === 'Download')
                            <button type="submit" class="btn btn-success btn-lg">Download</button>
                        @else
                            <button type="submit" class="btn btn-success btn-lg">Mark as Complete</button>
                        @endif
                    </form>
                </div>
            </div>
            @if(count($lecture_user))
                <div class="card">
                    <div class="card-header"><em class="fa fa-clock-o"></em> History</div>
                    <div class="card-body">
                        <ul style="margin-bottom:0">
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
@endsection
