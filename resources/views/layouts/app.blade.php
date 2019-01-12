<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />

    <style type="text/css">
        ul {
            margin-bottom: 0 !important;
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

        .course-card {
            margin-bottom: 30px;
            height: 300px;
            max-height: 300px;
        }

        .course-card-title {
            height:40px;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" integrity="sha256-oSgtFCCmHWRPQ/JmR4OoZ3Xke1Pw4v50uh6pLcu+fIc=" crossorigin="anonymous"></script>
    @yield('footer')
</body>
</html>
