<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>签到系统</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/vue-material@0.7.1/dist/vue-material.css">
    <link href="{{ mix('/css/admin.css') }}" rel="stylesheet">
    <style>
        .md-title {
            text-align: center;
        }
    </style>
</head>
<body id="app-layout">
<div id="app">
    @yield('content')
</div>
<!-- JavaScripts -->
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/main.js') }}"></script>
@if(config('app.env') != 'production')
<script src="http://localhost:35729/livereload.js?snipver=1.0.0"></script>
@endif
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
