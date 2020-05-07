<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--===============================================================================================-->
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
{{--    <link rel="stylesheet" type="text/css" href="{{ url('/table/css/main.css') }}">--}}
    <title>Результат</title>
</head>
<body>
<style>

</style>
@if(isset($data))
    <pre>Таблицю завантажено! Кількість рядків: {{ $lastRow }}</pre>
    {!! $menu->asUl() !!}

    <table border="1px">
        <thead>
        <tr>
            <th>Учень</th>
            <th>Клас</th>
            <th>Оцінка</th>
            @if(!($mode == 1 || $mode == 2 || $mode == 3 || $mode == 5))
                <th>Вчитель</th>
            @endif
        </tr>
        </thead>
        <tbody>

        @for($i = 0; $i < count($data); $i++)
            <tr>
                @foreach($data[$i] as $item)
                    <td>{{ $item}}</td>
                @endforeach
            </tr>
        @endfor

        </tbody>
    </table>

    <ul>
        <a href="/delete" style="color: black">
            <li>Змінити файл</li>
        </a>
    </ul>
@endif

</body>
</html>
