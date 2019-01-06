@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-40 mb-60">
            <h2 class="mb-10">Search</h2>
            <p>Enter a search term below to search for content</p>
            <form action="{{ route('library.search') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                                <span class="input-group-text" id="title-input-group">
                                    <em class="fa fa-search"></em>
                                </span>
                    </div>
                    <input type="text" class="form-control form-control-lg" placeholder="" aria-label="Title" aria-describedby="title-input-group" required name="title">
                </div>
            </form>
        </div>
        <div class="col-md-12 mb-60">
            <h2 class="mb-10">Browse by Skill</h2>
            <p>Click a skill below to see related content</p>
            @foreach($skills as $skill)
                <form action="{{ route('library.search') }}" method="post" style="display:inline-block">
                    @csrf
                    <input type="hidden" name="skill" value="{{ $skill->title }}">
                    <button type="submit" class="btn btn-default mr-5 mb-10" style="color:{{ $skill->color }}"><em class="fa fa-circle-o"></em> {{ $skill->title }}</button>
                </form>
            @endforeach
        </div>
        <div class="col-md-12">
            <h2 class="mb-10">Browse by Type</h2>
            <p>Click a lecture type below to see related content</p>
            <div class="row">
                @foreach($lecture_types as $key => $val)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <form action="{{ route('library.search') }}" method="post" style="display:inline-block">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ $key }}">
                                    <button type="submit" style="font-size:25px" class="text-center btn btn-default">
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
