@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-40">
                <div class="card-header bg-success text-white">Add Course</div>
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
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The title of this course that will appear at the top of the page"></em>
                                <label for="courseTitle">Course Title <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" id="courseTitle" value="{{ old('title') }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A unique, url safe string that will be used as the link for this course"></em>
                                <label for="courseSlug">URL Slug <small class="small text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" id="courseSlug" value="{{ old('slug') }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The color that will be used as the background and accent color for this course"></em>
                                <label for="courseColor">Color <small class="small text-danger">*</small></label>
                                <input type="color" class="form-control" name="color" id="courseColor" value="{{ old('color', '#3991CF') }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="The interval (in days) in which a user is required to complete this course again"></em>
                                <label for="courseRecertifyInterval">Recertify Interval (in days) <small class="small text-danger">*</small></label>
                                <input type="number" class="form-control" name="recertify_interval" id="courseRecertifyInterval" value="{{ old('recertify_interval') }}" required autocomplete="off">
                            </div>
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A short description under 250 characters that will be displayed on the course preview"></em>
                                <label for="courseShortDescription">Short Description <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="short_description" id="courseShortDescription" cols="30" rows="3" required>{{ old('short_description') }}</textarea>
                            </div>
                            <div class="form-group col-sm-12">
                                <em class="fa fa-question-circle text-primary" data-toggle="tooltip" data-placement="top" title="A long description that will be displayed on under the About This Course section"></em>
                                <label for="courseLongDescription">Long Description <small class="small text-danger">*</small></label>
                                <textarea type="text" class="form-control" name="long_description" id="courseLongDescription" cols="30" rows="10" required>{{ old('long_description') }}</textarea>
                            </div>
                            <div class="text-right col-sm-12">
                                <a href="{{ route('courses.index') }}" class="btn btn-default btn-lg">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg"><em class="fa fa-save"></em> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    <script type="text/javascript">

        var Course = {

            created: function(){

                $('[name=title]').on('change', function(){

                    if($('[name=slug]').val() === '')
                    {
                        $('[name=slug]').val($('[name=title]').val());
                    }

                });

                $('[name=slug]').on('keyup', function(){

                    var slugify = App.slugify($('[name=slug]').val());

                    $('[name=slug]').val(slugify);

                });

            }

        };

        $(document).ready(function(){

            Course.created();

        });

    </script>
@endsection
