<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TYPING</title>
    @vite(['resources/sass/app.scss', 'resources/js/typing.js'])
</head>
<body>
@include('include.header')
<div class="container-fluid">
    <div class="row">
        @include('include.sidemenu')
        <main class="col-md-9 col-lg-10 px-md-4">
            @yield('content')
            @include('include.footer')
        </main>
    </div>
</div>
</body>
</html>