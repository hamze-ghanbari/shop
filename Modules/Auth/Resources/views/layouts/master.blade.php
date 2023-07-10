<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>فروشگاه اینترنتی دیجی کالا | ورود</title>

    {{--        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>--}}
    <script src="{{asset('jquery.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('icons/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/classes/_color_classes.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/classes/_typography_classes.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/auth/css/app.css') }}">

</head>
<body>
@yield('content')
@yield('script')
</body>
</html>
