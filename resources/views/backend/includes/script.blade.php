<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js', env('REDIRECT_HTTPS')) }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js', env('REDIRECT_HTTPS')) }}"></script>
<!-- overlayScrollbars -->
<script
src="{{ asset('vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js', env('REDIRECT_HTTPS')) }}">
</script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/dist/js/adminlte.js', env('REDIRECT_HTTPS')) }}"></script>

<script src="{{ asset('api/select-faculty.js', env('REDIRECT_HTTPS')) }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('vendor/plugins/jquery-mousewheel/jquery.mousewheel.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{ asset('vendor/plugins/raphael/raphael.min.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{ asset('vendor/plugins/jquery-mapael/jquery.mapael.min.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{ asset('vendor/plugins/jquery-mapael/maps/usa_states.min.js', env('REDIRECT_HTTPS')) }}"></script>
<!-- ChartJS -->
<script src="{{ asset('vendor/plugins/chart.js/Chart.min.js', env('REDIRECT_HTTPS')) }}"></script>

{{-- <!-- AdminLTE for demo purposes -->
<script src="{{ asset('vendor/dist/js/demo.js', env('REDIRECT_HTTPS')) }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('vendor/dist/js/pages/dashboard2.js', env('REDIRECT_HTTPS')) }}"></script>

<script src="{{ asset('js/select-kota.js', env('REDIRECT_HTTPS')) }}"></script>

@if (Request::is('backend/researchs') || Request::is('backend/users'))
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
