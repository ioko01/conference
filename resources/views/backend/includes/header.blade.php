<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | DASHBOARD</title>

    <!-- Styles -->
    <link href="{{ asset('css/main.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet" defer>
    <link href="{{ asset('css/app.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet" defer>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
        href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css', env('REDIRECT_HTTPS')) }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('vendor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css', env('REDIRECT_HTTPS')) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css', env('REDIRECT_HTTPS')) }}">

    
</head>