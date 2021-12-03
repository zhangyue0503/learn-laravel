<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>messages</title>
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <script src="https://cdn.bootcdn.net/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="{{mix('js/app.js')}}"></script>

</head>
<body>



<script>
    Echo.channel("messages")
        .listen("Messages", (e)=>{
            console.log(e);
        });
</script>
</body>
</html>
