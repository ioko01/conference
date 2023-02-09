@section('script')
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js?v=3', env('REDIRECT_HTTPS')) }}"></script>

    <script src="{{ asset('js/app.js?v=3', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/main.js?v=3', env('REDIRECT_HTTPS')) }}" defer></script>
    <script src="{{ asset('js/animate.js?v=3', env('REDIRECT_HTTPS')) }}" defer></script>

    @if (Request::is('employee/research/show/*'))
        <script src="{{ asset('js/preview-image-payment.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('/'))
        <script src="{{ asset('api/countdown.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/show/*') ||
            Request::is('employee/research/send-edit/show/*') ||
            Request::is('employee/research/send-edit-2/show/*') ||
            Request::is('employee/research/uploadfile/*'))
        <script src="{{ asset('api/send-edit-upload-research.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee*') || Request::is('admin*'))
        <script src="{{ asset('api/select-faculty.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('register'))
        <script src="{{ asset('js/show-hide-password.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/select-kota.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/select-attend.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/uploadfile/*'))
        <script src="{{ asset('api/upload-video-poster.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/default-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/upload-poster-detail-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('posters'))
        <script src="{{ asset('js/poster-detail-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/default-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('orals/link'))
        <script src="{{ asset('js/oral-detail-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
        <script src="{{ asset('js/default-modal.js?v=3', env('REDIRECT_HTTPS')) }}"></script>
    @endif

    @if (Request::is('employee/research/*'))
        @if (!Request::is('employee/research/send'))
            <script src="{{ asset('vendor/plugins/datatables/datatables.min.js?v=3', env('REDIRECT_HTTPS')) }}" defer></script>
            <script>
                $(document).ready(function() {
                    $(`.dataTable`).DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        bAutoWidth: false,
                        classes: {
                            sFilterInput: "form-control",
                            sLengthSelect: "form-select w-100",
                            sPageButton: "btn btn-outline-green rounded-0 mx-1",
                            sPageButtonActive: "btn btn-green rounded-0 text-white",
                        },
                        language: {
                            info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                            infoEmpty: "",
                            sInfoFiltered: "(คัดกรองจาก _MAX_ รายการ)",
                            sLengthMenu: "แสดง _MENU_ รายการ",
                            sLoadingRecords: "",
                            sSearch: "ค้นหา: ",
                            sZeroRecords: "ไม่มีข้อมูลในตาราง",
                            paginate: {
                                sNext: "ถัดไป",
                                sPrevious: "ก่อนหน้า",
                                first: "หน้าแรก",
                                last: "หน้าสุดท้าย",
                            },
                        },
                        dom: '<"top mb-3 w-100"f><"text-center"t><"d-flex flex-wrap justify-content-between"ip><"clear">',
                    });
                });
            </script>
        @endif
    @endif

    @if (Request::is('list/*') || Request::is('orals') || Request::is('orals/link') || Request::is('proceeding/*'))
        <script src="{{ asset('vendor/plugins/datatables/datatables.min.js?v=3', env('REDIRECT_HTTPS')) }}" defer></script>
        <script>
            $(document).ready(function() {
                $(`.dataTable`).DataTable({
                    pageLength: 10,
                    lengthChange: true,
                    bAutoWidth: false,
                    classes: {
                        sFilterInput: "form-control",
                        sLengthSelect: "form-select w-100",
                        sPageButton: "btn btn-outline-green rounded-0 mx-1",
                        sPageButtonActive: "btn btn-green rounded-0 text-white",
                    },
                    language: {
                        info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                        infoEmpty: "",
                        sInfoFiltered: "(คัดกรองจาก _MAX_ รายการ)",
                        sLengthMenu: "แสดง _MENU_ รายการ",
                        sLoadingRecords: "",
                        sSearch: "ค้นหา: ",
                        sZeroRecords: "ไม่มีข้อมูลในตาราง",
                        paginate: {
                            sNext: "ถัดไป",
                            sPrevious: "ก่อนหน้า",
                            first: "หน้าแรก",
                            last: "หน้าสุดท้าย",
                        },
                    },
                    dom: '<"top mb-3 w-100"f><"text-center"t><"d-flex flex-wrap justify-content-between"ip><"clear">',
                });
            });
        </script>
    @endif
@endsection
