@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($course->isCompleted())
                <div class="card bg-success text-white mb-30">
                    <div class="card-body">
                        <h4><em class="fa fa-check"></em> Course Completed</h4>
                        You completed this course
                    </div>
                </div>
            @endif
            <div class="card" style="margin-bottom:30px;">
                <div class="card-body">
                    <h2 style="margin-bottom:10px;">{{ $course->title }}</h2>
                    <p>{{ $course->long_description }}</p>
                    <div>
                        <div style="margin-bottom:10px;" class="small">Skills you will earn in this course:</div>
                        @foreach($course->skills() as $skill)
                            <span style="color:{{ $skill->color }};margin-right:5px;"><em class="fa fa-circle-o"></em> {{ $skill->title }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @foreach($course->assignedLessons as $lesson)
                <div class="card mb-40">
                    @if($lesson->lesson->isCompleted(false))
                        <div class="card-header bg-success text-white">
                            <em class="fa fa-check"></em> {{ $lesson->lesson->title }}
                            <span class="pull-right">
                                Completed
                            </span>
                        </div>
                    @else
                        <div class="card-header">
                            {{ $lesson->lesson->title }}
                        </div>
                    @endif
                    <div>
                        <table class="table no-mb">
                            <tbody>
                                @foreach($lesson->lesson->assignedLectures as $lecture)
                                    <tr>
                                        <td style="width:50px;">
                                            @if($lecture->lecture->type === 'Quiz')
                                                <em class="fa fa-play-circle"></em>
                                            @elseif($lecture->lecture->type === 'Download')
                                                <em class="fa fa-download"></em>
                                            @elseif($lecture->lecture->type === 'Video')
                                                <em class="fa fa-video-camera"></em>
                                            @else
                                                <em class="fa fa-file-o"></em>
                                            @endif
                                        </td>
                                        <td style="width:100px;" class="{{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">
                                            {{ $lecture->lecture->type }}
                                        </td>
                                        <td class="{{ $lecture->lecture->isCompleted() ? 'completed-lecture' : '' }}">
                                            <a href="{{ route('lectures.show', [$course, $lesson->lesson, $lecture->lecture]) }}">{{ $lecture->lecture->title }}</a>
                                        </td>
                                        <td class="text-right">
                                            @if(count($lecture->lecture->completionHistory()) > 0)

                                                   @if(strtotime($lecture->lecture->completionHistory()[0]->recertify_at) > time())
                                                        <span class="text-danger">
                                                            Recertify due {{ $lecture->lecture->completionHistory()[0]->recertify_at->format('Y-m-d') }}
                                                        </span>
                                                   @else
                                                        <span class="text-success">
                                                            Completed {{ $lecture->lecture->completionHistory()[0]->completed_at->format('Y-m-d') }}
                                                        </span>
                                                   @endif

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
