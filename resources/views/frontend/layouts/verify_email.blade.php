@include('includes.loading')
@include('includes.head')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@yield('head')

<body style="background-color: #dfdfdf">
    @yield('loading')

    <div id="page" class="hidden">

        <div id="content">
            @yield('content')
        </div>

    </div>

</body>

</html>
