@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Course</div>
                @if ($errors->any())
                    <div class="alert alert-danger" style="border-radius: 0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('courses.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="courseTitle">Course Title <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="courseTitle" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="courseSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="courseSlug" value="{{ old('slug') }}">
                        </div>
                        <div class="form-group">
                            <label for="courseRecertifyInterval">Recertify Interval (in days) <small class="small text-danger">*</small></label>
                            <input type="number" class="form-control" name="recertify_interval" id="courseRecertifyInterval" value="{{ old('recertify_interval') }}">
                        </div>
                        <div class="form-group">
                            <label for="courseShortDescription">Short Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="short_description" id="courseShortDescription" cols="30" rows="3">{{ old('short_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="courseLongDescription">Long Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="long_description" id="courseLongDescription" cols="30" rows="10">{{ old('long_description') }}</textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success btn-lg">Save & Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
