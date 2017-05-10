<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MeiZhuo Studio</title>
    {{-- css --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
</head>
<body>
@yield('content')
<div id="app" v-cloak>
</div>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/main.js') }}"></script>
@if(config('app.env') != 'production')
<script src="http://localhost:35729/livereload.js?snipver=1.0.0"></script>
@endif
</body>
</html>