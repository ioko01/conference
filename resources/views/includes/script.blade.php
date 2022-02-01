@section('script')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
@if (Request::is('employee*') || Request::is('admin*'))
<script src="{{ asset('api/select-faculty.js') }}"></script>
@endif

@if (Request::is('register'))
<script src="{{ asset('js/select-kota.js') }}"></script>
@endif

@if (Request::is('employee/research/*') || Request::is('admin/research'))
<script src="{{ asset('js/preview-image-payment.js') }}"></script>
<script src="{{ asset('js/paginate.js') }}"></script>
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
@endsection