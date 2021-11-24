<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
</head>
<body>

<h1>{{$title}}</h1>

{{$content}}

{!! $content !!}

<ul>
@foreach($menu as $v)
    <li>{{$v}}</li>
@endforeach
</ul>


</body>
</html>
