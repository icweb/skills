<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.min.css">
    <link href="{{ asset('/vendor/colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">



    <style type="text/css">
        ul {
            margin-bottom: 0 !important;
        }

        .favorites-success-badge {
            width: 30px;
            height: 50px;
            padding: 10px 3px 3px 3px;
            position: absolute;
            right: 15px;
            text-align: center;
            color: #ffffff;
            background-color: #FFD600;
        }

        .course-success-badge {
            width: 30px;
            height: 50px;
            padding: 10px 3px 3px 3px;
            position: absolute;
            right: 15px;
            text-align: center;
            color: #ffffff;
        }

        .badge-arrow-up {
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 15px solid white;
            position:absolute;
            bottom: 0;
            right: 1px;
        }

        .no-mb {
            margin-bottom: 0;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-40 {
            margin-top: 40px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .mb-40 {
            margin-bottom: 40px;
        }

        .mb-60 {
            margin-bottom: 60px;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        .mr-10 {
            margin-right: 10px;
        }

        .pt-100 {
            padding-top: 100px;
        }

        .pr-10 {
            padding-right: 10px;
        }

        .my-course-card {
            margin-bottom: 30px;
            height: 270px;
            max-height: 270px;
        }

        .favorites-card {
            margin-bottom: 30px;
            height: 130px;
            max-height: 300px;
        }

        .favorites-card-title {
            height:50px;
            padding-right: 20px;
        }

        .favorites-card-description {
            height: 30px;
            overflow: hidden;
        }

        .course-card {
            margin-bottom: 30px;
            height: 300px;
            max-height: 300px;
        }

        .course-card-title {
            height:40px;
            padding-right: 20px;
        }

        .course-card-description {
            height: 70px;
            overflow: hidden;
        }

        .course_skills {
            height: 50px;
            margin-bottom: 20px;
        }

        .skill-badge {
            margin-right: 5px;
            display: inline-block;
        }

        .half-opacity {
            opacity: .5;
        }

        .card-completion {
            color: #BDBDBD;
            font-weight: 500;
        }

        .completed-lecture,
        .completed-lecture * {
            text-decoration: line-through;
            color: #38c172 !important;
        }

        .show-on-lessons-edit {
            display: none;
        }

        .hide-on-lessons-edit {
            display: block;
        }

        .show-on-course-edit {
            display: none;
        }

        .hide-on-course-edit {
            display: block;
        }

        .manage-course-panel {
            margin-top: -30px;
        }

        .navbar {
            z-index: 2;
        }

        .text-orange {
            color: #F9A825;
        }

        .text-warning {
            color: #F9A825;
        }

        .btn-su

        .btn-yellow {
            background-color: #FFD600;
            color: #ffffff;
        }

        .btn-warning {
            background-color: #F9A825;
            color: #ffffff;
        }

        .bg-warning {
            background-color: #F9A825 !important;
            color: #ffffff;
        }

        .text-black
        {
            color: #000000 !important;
        }

        body.dragging, body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        ol.sortList li.placeholder {
            position: relative;
            /** More li styles **/
        }
        ol.sortList li.placeholder:before {
            position: absolute;
            /** Define arrowhead **/
        }

        .sortable {
            list-style: none;
        }

        .select-cursor {
            cursor: move;
        }

        .articleBodyHtml p{
            margin-bottom: 0;
        }

        body
        {
            background-color: #ebebeb !important;
            color: #424c54 !important;
            font-family:Nunito, sans-serif !important;
        }

        .card
        {
            background-color: #fafafa;
            border: 0 solid rgba(0,0,0,.125);
            border-radius: .35rem !important;
            -webkit-box-shadow: 0 2px 3px rgba(0,0,0,.16);
            box-shadow: 0 2px 3px rgba(0,0,0,.16);
            margin-bottom: 20px;
        }

        .card-header
        {
            font-weight: bold;
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}">Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('skills.index', auth()->user()) }}">Skills</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('library.index') }}">Library</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('favorites.index') }}">Favorites</a></li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4" style="padding-top:0 !important;">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="{{ secure_asset('/vendor/sortable/sortable.js') }}"></script>
    <script src="{{ secure_asset('/vendor/colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/js/bootstrap-select.min.js"></script>

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey={{ env('TINYMCE_API_KEY') }}"></script>


    <script type="text/javascript">

        var App = {

            slugify: function(text)
            {
                return text.toString().toLowerCase()
                    .replace(/&/g, '-and-')         // Replace & with 'and'
                    .replace(/[\s\W-]+/g, '-')      // Replace spaces, non-word characters and dashes with a single dash (-)
            },

            charactersLeft: function(field, limit, canvas){

                $(canvas).text(limit + ' characters');

                $(field).keyup(function(){
                    var value = limit - $(this).val().length;
                    var label = value === 1 ? '1 character' : (value + ' characters');
                    $(canvas).text(label);
                });

                var value2 = limit - $(field).val().length;
                var label2 = value2 === 1 ? '1 character' : (value2 + ' characters');
                $(canvas).text(label2);

            },

            created: function(){

                $('[data-toggle="tooltip"]').tooltip();

            }

        };

        $(document).ready(function(){

            App.created();

        });

    </script>
    @yield('footer')
</body>
</html>
