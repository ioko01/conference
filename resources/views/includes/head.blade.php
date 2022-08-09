@section('head')

    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="LRU Conference">
        <meta name="keywords" content="conference, lru conference">
        <meta name="author" content="thanapong soontarawirat">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('fontawesome-free-6.0.0-web/css/all.min.css', env('REDIRECT_HTTPS')) }}"
            defer />

        {{-- script --}}
        <script src="{{ asset('js/preloading.js', env('REDIRECT_HTTPS')) }}"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet" defer>
        <link href="{{ asset('css/main.min.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet" defer>

        @if (Request::is('employee/research/*') || Request::is('list/*'))
            <link rel="stylesheet" href="{{ asset('css/paginate.css', env('REDIRECT_HTTPS')) }}" defer>
            <link rel="stylesheet" href="{{ asset('css/ligne.css', env('REDIRECT_HTTPS')) }}" defer>
        @endif

        <title>{{ config('app.name') }}</title>
    </head>
@endsection
