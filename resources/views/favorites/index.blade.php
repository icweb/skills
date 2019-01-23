@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mt-40">
                @if(count($favorites))
                    <div class="col-md-12 mb-40">
                        <h2 class="mb-40">My Favorites</h2>
                        <div class="row">
                            @foreach($favorites as $favorite)
                                <div class="col-md-6">
                                    <div class="card favorites-card" style="border-top: 5px solid #FFD600;">
                                        <div class="card-body">
                                            <h4 class="favorites-card-title">{{ $favorite->lecture->title }}</h4>
                                            <a href="{{ route('library.show', $favorite->lecture) }}" class="btn btn-yellow">View {{ $favorite->lecture->type }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-sm-12">
                        <h4 class="mt-40">No Favorites Found</h4>
                        Check back after you've added something to your favorites.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
