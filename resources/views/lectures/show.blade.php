@extends('layouts.app')

@section('content')
    @if(!$lecture->allow_print)
        @include('partials.section-no-print')
    @endif
    <div class="container" id="lectureContainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(isset($course))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="border-top-left-radius: 0!important;border-top-right-radius: 0!important;">
                            <li class="breadcrumb-item"><a href="{{ route('courses.show', [$course]) }}">{{ $course->title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $lecture->title }}</li>
                        </ol>
                    </nav>
                    @if($lecture_lesson->count() > 1)
                        <div class="card mt-10 d-print-none">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($lecture_lesson as $item)
                                        <div class="col text-center">
                                            <a href="{{ route('lectures.show', [$course, $lesson, $item->lecture]) }}" class="{{ $item->lecture_id === $lecture->id ? 'text-success' : 'text-black' }}">
                                                @if($item->lecture->isCompleted())
                                                    <em class="fa fa-check-circle-o fa-lg"></em><br>
                                                @else
                                                    <em class="fa fa-circle-o fa-lg"></em><br>
                                                @endif
                                                {{ $item->lecture->type }}
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
                </div>

                @if($errors->any() && !empty($errors->first()))
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if($lecture->type === 'Quiz')
                    @include('lectures.show-quiz', ['body' => $lecture->body])
                @elseif($lecture->type === 'Article')
                        @include('lectures.show-article', ['body' => $lecture->body])
                @elseif($lecture->type === 'Download')
                    @include('lectures.show-download', ['body' => $lecture->body])
                @endif

                <div class="accordion d-print-none" id="lectureStats">
                    @if(count($lecture_user) && $lecture->show_completion_history)
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <span class="pull-right mt-10" style="font-size:12px;">Click to expand</span>
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#completionHistory" aria-expanded="false" aria-controls="completionHistory">
                                        <em class="fa fa-clock-o"></em> Completion History
                                    </button>
                                </h2>
                            </div>
                            <div id="completionHistory" class="collapse" data-parent="#lectureStats">
                                <div class="card-body">
                                    <ul>
                                        @foreach($lecture_user as $record)
                                            <li> You completed this lecture on {{ $record->completed_at->format('m/d/Y') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(count($certified_users) && $lecture->show_certified_users)
                        <div class="card">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <span class="pull-right mt-10" style="font-size:12px;">Click to expand</span>
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#certifiedUsers" aria-expanded="false" aria-controls="certifiedUsers">
                                        <em class="fa fa-check"></em> Certified Users
                                    </button>
                                </h2>
                            </div>
                            <div id="certifiedUsers" class="collapse" aria-labelledby="headingThree" data-parent="#lectureStats">
                                <div class="card-body">
                                    <table style="width: 100%">
                                        @foreach($certified_users as $user)
                                            <tr>
                                                <td style="width:50px;padding: 10px 0;vertical-align: middle">
                                                    <em class="fa fa-user-circle-o fa-2x mb-0"></em>
                                                </td>
                                                <td style="padding: 10px 0;vertical-align: middle">
                                                    <h4 class="mb-0">{{ $user->user->name }}</h4>
                                                </td>
                                                <td class="text-right text-success" style="width: 150px;padding: 10px 0;vertical-align: middle">
                                                    Certified {{ $user->completed_at->format('m/d/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
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