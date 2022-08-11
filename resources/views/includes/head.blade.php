@section('head')

    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description"
            content="สถาบันวิจัยและพัฒนา มหาวิทยาลัยราชภัฏเลย ได้จัดการประชุมวิชาการระดับชาติ ราชภัฏเลยวิชาการขึ้น">
        <meta name="keywords" content="conference, lru conference, lru, conference lru">
        <meta name="author" content="Research and Development Institute - Loei Rajabhat University">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('fontawesome-free-6.0.0-web/css/all.min.css', env('REDIRECT_HTTPS')) }}" />

        {{-- script --}}
        <script src="{{ asset('js/preloading.js', env('REDIRECT_HTTPS')) }}" async></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet">
        <link href="{{ asset('css/main.min.css', env('REDIRECT_HTTPS')) }}" rel="stylesheet">

        @if (Request::is('employee/research/*') || Request::is('list/*'))
            <link rel="stylesheet" href="{{ asset('css/paginate.css', env('REDIRECT_HTTPS')) }}">
            <link rel="stylesheet" href="{{ asset('css/ligne.css', env('REDIRECT_HTTPS')) }}">
        @endif

        <title>{{ config('app.name') }}</title>
    </head>
@endsection
