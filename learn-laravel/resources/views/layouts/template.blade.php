<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>
@include('layouts.header')

@yield('content')

@include('layouts.footer')
</body>
</html>
