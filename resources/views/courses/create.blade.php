@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Course</div>
                <div class="card-body">
                    <form action="{{ route('courses.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="courseTitle">Course Title <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="courseTitle">
                        </div>
                        <div class="form-group">
                            <label for="courseSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="courseSlug">
                        </div>
                        <div class="form-group">
                            <label for="courseRecertifyInterval">Recertify Interval (in days) <small class="small text-danger">*</small></label>
                            <input type="number" class="form-control" name="recertify_interval" id="courseRecertifyInterval">
                        </div>
                        <div class="form-group">
                            <label for="courseShortDescription">Short Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="short_description" id="courseShortDescription" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="courseLongDescription">Long Description <small class="small text-danger">*</small></label>
                            <textarea type="text" class="form-control" name="long_description" id="courseLongDescription" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Save & Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
