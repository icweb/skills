@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-30">
                <div class="card-body">
                    <h2 class="mb-10">{{ $course->title }}</h2>
                    <p class="mb-0">{{ $course->long_description }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-success text-white">Add Lesson</div>
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
                    <form action="{{ route('lessons.store', [$course]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="lessonTitle">Lesson Title <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="title" id="lessonTitle" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="lessonSlug">URL Slug <small class="small text-danger">*</small></label>
                            <input type="text" class="form-control" name="slug" id="lessonSlug" value="{{ old('slug') }}">
                        </div>
                        <div class="form-group">
                            <label>Associated Skills</label><br>
                            @foreach($skills as $skill)
                                <input type="checkbox" name="associated_skills_{{ $skill->id }}" {{ old('associated_skills_' . $skill->id) === 'on' ? 'checked' : '' }}> {{ $skill->title }} <br>
                            @endforeach
                        </div>
                        <div class="text-right">
                            <a href="{{ route('courses.show', [$course]) }}#editLessons" class="btn btn-default btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
