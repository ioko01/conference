@section('script')
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js', env('REDIRECT_HTTPS')) }}"></script>

    <script src="{{ asset('js/app.js', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/main.js', env('REDIRECT_HTTPS')) }}" defer></script>

    @if (Request::is('/'))
        <script src="{{ asset('api/countdown.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/send-edit/show/*') || Request::is('employee/research/send-edit-2/show/*'))
        <script src="{{ asset('api/send-edit-upload-research.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee*') || Request::is('admin*'))
        <script src="{{ asset('api/select-faculty.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('register'))
        <script src="{{ asset('js/select-kota.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/uploadfile/*'))
        <script src="{{ asset('api/upload-video-poster.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/show/*') || Request::is('list/*'))
        <script src="{{ asset('js/preview-image-payment.js', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/paginate.js', env('REDIRECT_HTTPS')) }}"></script>
        <script>
            let options = {
                numberPerPage: 10, //Cantidad de datos por pagina
                goBar: true, //Barra donde puedes digitar el numero de la pagina al que quiere ir
                pageCounter: true, //Contador de paginas, en cual estas, de cuantas paginas
            };

            let filterOptions = {
                el: "#search", //Caja de texto para filtrar, puede ser una clase o un ID
            };

            paginate.init(".list", options, filterOptions);
        </script>
    @endif
@endsection
