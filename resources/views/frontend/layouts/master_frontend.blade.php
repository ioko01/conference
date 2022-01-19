@include('includes.loading')
@include('includes.head')
@include('includes.navbar')
@include('includes.footer')
@include('includes.button_to_top')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@yield('head')

<body>
    @yield('loading')

    <div id="page" class="hidden">
        @yield('navbar-topbar')

        <div id="content">
            @yield('content')
        </div>

        @yield('footer')
        @yield('btn-to-top')
    </div>

</body>

</html>