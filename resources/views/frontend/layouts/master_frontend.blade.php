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

    @if (Request::is('employee*'))
    <script src="{{ asset('js/select-option-group.js') }}"></script>
    @endif

    @if (Request::is('employee/research/*'))
    <script src="{{asset('js/paginate.js')}}"></script>
    <script>
        let options = {
            numberPerPage: 20, //Cantidad de datos por pagina
            goBar: true, //Barra donde puedes digitar el numero de la pagina al que quiere ir
            pageCounter: true, //Contador de paginas, en cual estas, de cuantas paginas
        };
    
        let filterOptions = {
            el: "#search", //Caja de texto para filtrar, puede ser una clase o un ID
        };
    
        paginate.init(".list", options, filterOptions);
    </script>
    @endif

</body>

</html>