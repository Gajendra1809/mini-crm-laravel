<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('login.post')}}" method="POST">
        @csrf
        <input type="email" name="email" id="">
        <input type="password" name="password" id="">
        <button>submit</button>
    </form>
    
</body>
</html>