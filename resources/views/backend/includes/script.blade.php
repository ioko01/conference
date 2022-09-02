<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('vendor/plugins/jquery/jquery.min.js', env('REDIRECT_HTTPS')) }}"></script>

<script src="{{ asset('js/app.js', env('REDIRECT_HTTPS')) }}" defer></script>
<script src="{{ asset('js/main.js', env('REDIRECT_HTTPS')) }}" defer></script>

<!-- Bootstrap -->
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js', env('REDIRECT_HTTPS')) }}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js', env('REDIRECT_HTTPS')) }}">
</script>

<script src="{{ asset('vendor/plugins/jquery-ui/jquery-ui.min.js', env('REDIRECT_HTTPS')) }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/dist/js/adminlte.min.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{ asset('vendor/plugins/moment/moment.min.js', env('REDIRECT_HTTPS')) }}"></script>
<script src="{{ asset('vendor/plugins/fullcalendar/main.js', env('REDIRECT_HTTPS')) }}"></script>

<script src="{{ asset('api/select-faculty.js', env('REDIRECT_HTTPS')) }}"></script>

@if (Request::is('backend/researchs') ||
    Request::is('backend/researchs/management') ||
    Request::is('backend/researchs/*/edit') ||
    Request::is('backend/researchs/management/times/*') ||
    Request::is('backend/dashboard'))
    <script src="{{ asset('api/manage-research.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

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
{{-- <script src="{{ asset('vendor/dist/js/pages/dashboard2.js', env('REDIRECT_HTTPS')) }}"></script> --}}

<script src="{{ asset('js/select-kota.js', env('REDIRECT_HTTPS')) }}"></script>

@if (Request::is('backend/conference') || Request::is('backend/conference/*/edit'))
    <script src="{{ asset('js/get-start-end-datetime-local.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/download/*/edit') ||
    Request::is('backend/downloads') ||
    Request::is('backend/manual/*/edit') ||
    Request::is('backend/manuals'))
    <script src="{{ asset('js/toggle-file-link.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('api/change-notice.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/proceeding/*/file') || Request::is('backend/proceeding/*/file/*/edit'))
    <script src="{{ asset('js/toggle-file-link.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/poster/*/edit') ||
    Request::is('backend/posters') ||
    Request::is('backend/oral/*/edit') ||
    Request::is('backend/orals') ||
    Request::is('backend/line/*/edit') ||
    Request::is('backend/lines') ||
    Request::is('backend/download/*/edit') ||
    Request::is('backend/downloads') ||
    Request::is('backend/manual/*/edit') ||
    Request::is('backend/manuals') ||
    Request::is('backend/orals/link') ||
    Request::is('backend/orals/link/*/edit') ||
    Request::is('backend/proceeding/*/topic') ||
    Request::is('backend/proceeding/*/topic/*/edit') ||
    Request::is('backend/proceeding/*/file') ||
    Request::is('backend/proceeding/*/file/*/edit'))
    <script src="{{ asset('api/delete.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/lines') || Request::is('backend/line/*/edit'))
    <script src="{{ asset('js/line-detail-modal.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/default-modal.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/orals/link') || Request::is('backend/orals/link/*/edit'))
    <script src="{{ asset('js/oral-detail-modal.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/default-modal.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/posters') || Request::is('backend/poster/*/edit'))
    <script src="{{ asset('js/poster-detail-modal.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/default-modal.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/present-poster.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('api/get-research-with-topic-id.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/orals') || Request::is('backend/oral/*/edit'))
    <script src="{{ asset('js/present-oral.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('api/get-research-with-topic-id.js', env('REDIRECT_HTTPS')) }}"></script>
@endif

@if (Request::is('backend/researchs') ||
    Request::is('backend/users') ||
    Request::is('backend/researchs/management'))
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

@if (Request::is('backend/dashboard'))
    <script src="{{ asset('api/calendar.js', env('REDIRECT_HTTPS')) }}"></script>
    <script src="{{ asset('js/calendar.js', env('REDIRECT_HTTPS')) }}"></script>
@endif
