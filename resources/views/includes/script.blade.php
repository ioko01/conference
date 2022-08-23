@section('script')
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js', env('REDIRECT_HTTPS')) }}"></script>

    <script src="{{ asset('js/app.js', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/main.js', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/animate.js', env('REDIRECT_HTTPS')) }}" defer></script>

    @if (Request::is('/'))
        <script src="{{ asset('api/countdown.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/show/*') ||
        Request::is('employee/research/send-edit/show/*') ||
        Request::is('employee/research/send-edit-2/show/*') ||
        Request::is('employee/research/uploadfile/*'))
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
        <script src="{{ asset('js/default-modal.js', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/upload-poster-detail-modal.js', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('posters'))
        <script src="{{ asset('js/poster-detail-modal.js', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/default-modal.js', env('REDIRECT_HTTPS')) }}"></script>
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
    @if (Request::is('orals'))
        <script src="{{ asset('vendor/plugins/datatables/datatables.min.js', env('REDIRECT_HTTPS')) }}" defer></script>
        <script>
            $(document).ready(function() {
                $(`.dataTable`).DataTable({
                    searching: true,
                    lengthChange: false,
                    bAutoWidth: false,
                    aoColumns: [{
                            sWidth: '15%'
                        },
                        {
                            sWidth: '20%'
                        },
                        {
                            sWidth: 'auto'
                        }
                    ],
                    classes: {
                        sFilterInput: "form-control w-100",
                        sLengthSelect: "form-select w-100",
                        sPageButton: "btn btn-outline-dark rounded-0 mx-1",
                        sPageButtonActive: "btn btn-dark rounded-0 text-white ",
                    },
                    language: {
                        info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                        infoEmpty: "",
                        sInfoFiltered: "(คัดกรองจาก _MAX_ รายการ)",
                        sLengthMenu: "แสดง _MENU_ รายการ",
                        sLoadingRecords: "",
                        sSearch: "ค้นหา: ",
                        sZeroRecords: "ไม่มีผลงานนำเสนอ",
                        paginate: {
                            sNext: "ถัดไป",
                            sPrevious: "ก่อนหน้า",
                            first: "หน้าแรก",
                            last: "หน้าสุดท้าย",
                        },
                    },
                    dom: '<"text-center"t><"d-flex flex-wrap justify-content-between"ip><"clear">',
                });
            });
        </script>
    @endif
@endsection
