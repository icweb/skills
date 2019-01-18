@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid" style="padding: 3rem 4rem;">
        <h1 class="display-4" style="font-size:28px;"><b>Welcome to the {{ env('APP_NAME') }} Library</b></h1>
        <p class="lead">Here you can quickly search and browse course lectures. Use the search field below, or browse by filters using the "Browse by" sections.</p>
        <hr class="my-4">
        <form action="{{ route('library.search') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                        <span class="input-group-text" id="title-input-group">
                            <em class="fa fa-search"></em>
                        </span>
                </div>
                <input type="text" class="form-control form-control-lg" placeholder="Search..." aria-label="Title" aria-describedby="title-input-group" required name="title" autocomplete="off" id="searchInput" minlength="3">
                <button type="submit" class="btn btn-primary btn-lg" role="button" style="border-top-left-radius: 0; border-bottom-left-radius: 0;"><em class="fa fa-search"></em> Search</button>
            </div>
        </form>
    </div>
    <div style="padding: 10px 75px;">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-60">
                <h2 class="mb-10">Browse by Skill</h2>
                <p>Browse course content by a specific skill by selecting an item below.</p>
                @foreach($skills as $skill)
                    <form action="{{ route('library.search') }}" method="post" style="display:inline-block">
                        @csrf
                        <input type="hidden" name="skill" value="{{ $skill->title }}">
                        <button type="submit" class="btn btn-default mr-5 mb-10" style="color:{{ $skill->color }}"><em class="fa fa-circle-o"></em> {{ $skill->title }}</button>
                    </form>
                @endforeach
            </div>
            <div class="col-md-12">
                <h2 class="mb-10">Browse by Lecture Type</h2>
                <p>Browse course content by a specific lecture type by selecting an item below.</p>
                <div class="row">
                    @foreach($lecture_types as $key => $val)
                        <div class="col-sm-4">
                            <div class="card mb-30">
                                <div class="card-body text-center">
                                    <form action="{{ route('library.search') }}" method="post" style="display:inline-block">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $key }}">
                                        <button type="submit" style="font-size:15px" class="text-center btn btn-default">
                                            <em class="fa fa-{{ $val }} fa-lg"></em><br>
                                            {{ $key }}
                                        </button>
                                    </form>
                                </div>
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
