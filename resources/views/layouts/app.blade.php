<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
<head >
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge" >
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" >
    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}" >

    <title >{{ config('app.name', 'Laravel') }}</title >

    <!-- Styles -->
    {{--
        <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    --}}

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/icon?family=Material+Icons" >

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600"
          rel="stylesheet"
          type="text/css" >

    <style type="text/css" >
        html, body {
            color: #ffffff;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
        }
    </style >
</head >
<body >
<div id="app" >

</div >
<!-- Scripts -->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS_9BsQpqTP8EVuMZ7rQ9gMCl0wmqhm7k&libraries=places" ></script >
<script src="{{ asset(mix('js/app.js')) }}" ></script >
</body >
</html >
