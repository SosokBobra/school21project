<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Завантажте файл!</title>
    <link rel="icon" type="image/png" href="{{ url('/table/images/icons/favicon.ico') }} "/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/table/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/table/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/table/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/table/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/public/table/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('/table/css/util.css') }}">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h1>{{ session()->pull('status', 'Завантажте файл!') }}</h1>
        @csrf
        <input type="file" name="file" id="file">
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
        <br><br>
        <input type="submit" value="Завантажити">
    </form>
</body>
</html>
