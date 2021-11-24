<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<h2>表单验证</h2>
<form method="post" action="http://laravel8/validate/store">
    <label>标题</label><input name="title"/><br/>
    <label>作者</label><input name="author"/><br/>
    <label>年龄</label><input name="age"/><br/>
    <label>内容</label><input name="body"/><br/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <button type="submit">提交</button>
</form>

<h2>自定义验证</h2>
<form method="post" action="http://laravel8/validate/store2">
    <label>标题</label><input name="title"/><br/>
    <label>作者</label><input name="author"/><br/>
    <label>年龄</label><input name="age"/><br/>
    <label>内容</label><input name="body"/><br/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <button type="submit">提交</button>
</form>

</body>
</html>
