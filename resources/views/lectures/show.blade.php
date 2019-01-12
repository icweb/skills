@extends('layouts.app')

@section('content')
    @if(!$lecture->allow_print)
        <div style="display:none;padding-top:50px" class="d-print-block text-center">
            <span class="fa-stack" style="font-size:300px;margin-bottom: 50px;">
              <i class="fa fa-print fa-stack-1x"></i>
              <i class="fa fa-ban fa-stack-2x text-danger"></i>
            </span>
            <br>
            <h1 class="text-center" style="font-size:100px;margin-bottom: 50px">Printing is<br>disabled on<br>this page</h1>
            <p class="text-center" style="font-size:50px;">Please contact the site<br>administrator for more<br>information</p>
        </div>
    @endif
    <div class="container" id="lectureContainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(isset($course))
                    <a href="{{ route('courses.show', [$course]) }}" class="btn btn-default mt-40 d-print-none"><em class="fa fa-angle-left"></em> Return to {{ $course->title }}</a>
                    @if($lesson->assignedLectures()->orderBy('position', 'asc')->get()->count() > 1)
                        <div class="card mt-10 d-print-none">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($lesson->assignedLectures()->orderBy('position', 'asc')->get() as $lesson_lecture)
                                        <div class="col text-center">
                                            <a href="{{ route('lectures.show', [$course, $lesson, $lesson_lecture->lecture]) }}" class="{{ $lesson_lecture->lecture_id === $lecture->id ? 'text-success' : 'text-black' }}">
                                                @if($lesson_lecture->lecture->isCompleted())
                                                    <em class="fa fa-check-circle-o fa-lg"></em><br>
                                                @else
                                                    <em class="fa fa-circle-o fa-lg"></em><br>
                                                @endif
                                                {{ $lesson_lecture->lecture->type }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                    <div class="mb-30">
                        <form action="{{ isset($course) ? route('favorites.store', [$course, $lesson, $lecture]) : route('favorites.store-wo-course', $lecture) }}" method="post" class="d-print-none">
                            @csrf
                            @if($lecture->isFavorite())
                                <button type="submit" class="btn btn-default btn-lg pull-right" style="background-color:#FFD600;color:#ffffff"><em class="fa fa-star-o"></em> Remove Favorite</button>
                            @else
                                <button type="submit" class="btn btn-default btn-lg pull-right" style="color:#FFD600;background-color:#ffffff;border: 1px solid #FFD600;"><em class="fa fa-star"></em> Favorite</button>
                            @endif
                        </form>
                        @if($lecture->allow_print)
                            <button type="button" class="d-print-none pull-right btn btn-default btn-lg mr-5" onclick="window.print()" style="border: 1px solid black;"><em class="fa fa-print"></em> Print</button>
                        @endif
                        <h2 class="mb-0 mt-40">{{ $lecture->title }}</h2>
                        @if($lecture->type === 'Quiz')
                            <div class="d-print-block mt-10" style="display:none">
                                <div class="row">
                                    <div class="col-9">
                                        <h6 class="mb-0" style="display:block;border-bottom: 1px solid black"><b>Name:</b> <span>{{ auth()->user()->name }}</span></h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="mb-0" style="display:block;border-bottom: 1px solid black"><b>Date:</b> <span>{{ date('m/d/Y h:ia', time()) }}</span></h6>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(isset($course))
                        <form action="{{ route('lectures.complete', [$course, $lesson, $lecture]) }}" method="post">
                    @else
                        <form action="#">
                    @endif
                    <div class="card mb-30">
                        @if($lecture->type === 'Article')
                            <div class="card-body">
                                {!! nl2br($lecture->body) !!}
                            </div>
                        @elseif($lecture->type === 'Download')
                            <div class="alert alert-warning mb-0">
                                <h4><em class="fa fa-download"></em> Downloadable Content</h4>
                                @if(isset($course))
                                    This item will be marked completed after your click the "Download File" button.
                                @endif
                            </div>
                        @elseif($lecture->type === 'Quiz')
                            @if(!isset($course))
                                <div class="alert alert-warning mb-0 d-print-none">
                                    <h4><em class="fa fa-lock"></em> Quiz Locked</h4>
                                    You must visit this content from inside a course to complete.
                                </div>
                            @endif
                            <div class="card-body">
                                <?php $count = 1; ?>
                                @foreach($lecture->questions as $question)
                                    @if($count > 1)
                                        <hr>
                                    @endif
                                    <div style="margin-bottom:20px;">
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
                                                    <input type="radio" name="q{{ $question->id }}" id="q{{ $question->id }}a{{ $answer->id }}">
                                                @endif
                                                 {{ $answer->title }}
                                            </div>
                                            <?php $count2 += 1; ?>
                                        @endforeach
                                    </div>
                                    <?php $count += 1; ?>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if(isset($course))
                        <div class="card mb-30 d-print-none">
                            <div class="card-body">
                                @csrf
                                @if($lecture->type === 'Quiz')
                                    <button type="submit" class="btn btn-success btn-lg">Submit Quiz</button>
                                @elseif($lecture->type === 'Download')
                                    <button type="submit" class="btn btn-success btn-lg">Download File</button>
                                @else
                                    <button type="submit" class="btn btn-success btn-lg">Mark as Complete</button>
                                @endif
                            </div>
                        </div>

                        @if(count($lecture_user))
                            <h3 class="mb-10 d-print-none">Completion History</h3>
                            <div class="card d-print-none mb-40">
                                <div class="card-body">
                                    <ul>
                                        @foreach($lecture_user as $record)
                                            <li> You completed this lecture on {{ $record->completed_at->format('m/d/Y') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endif
                    </form>
                    <div class="d-print-none">
                        <h3 class="mb-10">Certified Users</h3>
                        @foreach($certified_users as $user)
                            <div class="card mb-10">
                                <div class="card-body">
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width:50px;vertical-align: middle">
                                                <em class="fa fa-user-circle-o fa-2x mb-0"></em>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <h4 class="mb-0">{{ $user->user->name }}</h4>
                                            </td>
                                            <td class="text-right text-success" style="width: 150px;vertical-align: middle">
                                                Certified {{ $user->completed_at->format('m/d/Y') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Lecture = {

            created: function(){

                @if(!$lecture->allow_print)
                    $('#lectureContainer').addClass('d-print-none');
                @endif


            }

        };

        (function(){

            $(document).ready(function(){

                Lecture.created();

            });

        })();

    </script>
@endsection