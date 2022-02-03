@section('script')
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

@if (Request::is('admin*'))
<script src="{{ asset('api/update-status.js') }}"></script>
@endif

@if (Request::is('employee*') || Request::is('admin*'))
<script src="{{ asset('api/select-faculty.js') }}"></script>
@endif

@if (Request::is('register'))
<script src="{{ asset('js/select-kota.js') }}"></script>
@endif

@if (Request::is('admin/research'))
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
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