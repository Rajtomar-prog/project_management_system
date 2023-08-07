<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Jarvis') }} | @yield('page_title')</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}">{{ config('app.name', 'Jarvis') }} CRM</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                @section('content_auth')
                @show
            </div>
        </div>
    </div>
    <br><p>All rights reserved © {{ date('Y') }} {{ config('app.name', 'PMS') }}</p>
</body>
</html>
<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>
