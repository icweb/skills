@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class=""></div>
        <div class="col-md-12">
            <h2 class="mb-30 mt-40">Search Results</h2>

            @if(isset($criteria['title']))
                <div class="card mb-30">
                    <div class="card-body">
                        Showing <b>{{ count($lectures) === 1 ? '1 result ' : count($lectures) . ' results '  }}</b> for <b>{{ $criteria['title'] }}</b><br><br>
                        <a href="{{ route('library.index') }}" class="btn btn-success"><em class="fa fa-search"></em> New Search</a>
                    </div>
                </div>
            @elseif($criteria['skill'])
                <div class="card mb-30" style="background-color: {{ $skill->color }};color: #ffffff">
                    <div class="card-body">
                        <h3 class="mb-10"><em class="fa fa-{{ $skill->icon }}"></em> {{ $skill->title }}</h3>
                        <p class="mb-0">{!! $skill->description !!}</p>
                    </div>
                </div>
                <div class="card mb-30">
                    <div class="card-body">
                        Showing <b>{{ count($lectures) === 1 ? '1 result ' : count($lectures) . ' results '  }}</b> assigned to the skill <b>{{ $criteria['skill'] }}</b><br><br>
                        <a href="{{ route('library.index') }}" class="btn btn-success"><em class="fa fa-search"></em> New Search</a>
                    </div>
                </div>
            @elseif($criteria['type'])
                <div class="card mb-30">
                    <div class="card-body">
                        Showing <b>{{ count($lectures) === 1 ? '1 result ' : count($lectures) . ' results '  }}</b> of the type <b>{{ $criteria['type'] }}</b><br><br>
                        <a href="{{ route('library.index') }}" class="btn btn-success"><em class="fa fa-search"></em> New Search</a>
                    </div>
                </div>
            @endif

            @if(count($lectures))
                <div class="card">
                    <table class="table no-mb">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lectures as $lecture)
                            <tr>
                                <td style="width:50px;">
                                    @if($lecture->type === 'Quiz')
                                        <em class="fa fa-play-circle"></em>
                                    @elseif($lecture->type === 'Download')
                                        <em class="fa fa-download"></em>
                                    @elseif($lecture->type === 'Video')
                                        <em class="fa fa-video-camera"></em>
                                    @else
                                        <em class="fa fa-file-o"></em>
                                    @endif
                                </td>
                                <td style="width:100px;">
                                    {{ $lecture->type }}
                                </td>
                                <td>
                                    <a href="{{ route('library.show', $lecture) }}" target="_blank">{{ $lecture->title }}</a>
                                </td>
                                <td class="text-right">
                                    <div>
                                        @if(count($lecture->completionHistory()) > 0)

                                            @if(strtotime($lecture->completionHistory()[0]->recertify_at) > time())
                                                <span class="text-danger">
                                                Recertify due {{ $lecture->completionHistory()[0]->recertify_at->format('Y-m-d') }}
                                            </span>
                                            @else
                                                <span class="text-success">
                                                Completed {{ $lecture->completionHistory()[0]->completed_at->format('Y-m-d') }}
                                            </span>
                                            @endif

                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Lectures = {

            created: function(){



            }

        };

        (function(){

            $(document).ready(function(){

                Lectures.created();

            });

        })();

    </script>
@endsection
