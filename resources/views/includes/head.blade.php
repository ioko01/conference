@section('head')

    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

        {{-- script --}}
        <script src="{{ asset('js/preloading.js', env('REDIRECT_HTTPS')) }}"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
        <link href="{{ asset('css/main.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet">

        @if (Request::is('employee/research/*') || Request::is('admin/research'))
            <link rel="stylesheet" href="{{ asset('css/paginate.css', env('REDIRECT_HTTPS')) }}">
            <link rel="stylesheet" href="{{ asset('css/ligne.css', env('REDIRECT_HTTPS')) }}">
        @endif

        <title>{{ config('app.name') }}</title>
    </head>

@endsection
