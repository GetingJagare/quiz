<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>МОГ</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.0.4') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('chunks.navbar')

    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/admin.js?v=1.0.4') }}" defer></script>
</body>
</html>
