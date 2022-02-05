@section('head')

    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

        <!-- Scripts -->
        <script src="{{ secure_asset('js/app.js') }}" defer></script>
        <script src="{{ secure_asset('js/main.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/main.css') }}" rel="stylesheet">

        @if (Request::is('employee/research/*') || Request::is('admin/research'))
            <link rel="stylesheet" href="{{ secure_asset('css/paginate.css') }}">
            <link rel="stylesheet" href="{{ secure_asset('css/ligne.css') }}">
        @endif

        <title>{{ config('app.name') }}</title>
    </head>

@endsection
