<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Project Management System') }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">Project Management System</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    @guest
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-user"></span> {{ __('Register') }}</a></li>
                        <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> {{ __('Login') }}</a></li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{ url('/home') }}">Home</a></li>
                        <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                        <li><a href="{{ route('roles.index') }}">Manage Role</a></li>
                        <li><a href="{{ route('products.index') }}">Manage Product</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endguest
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>