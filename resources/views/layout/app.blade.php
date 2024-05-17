<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
    <script src="{{asset('public/js/bootstrap.bundle.js')}}"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap');
    </style>
    <title>@yield('title')</title>
</head>
<body>
<script src="{{asset('public/js/vue.global.js')}}"></script>
@include('layout.navbar')
@yield('main')
</body>
</html>
