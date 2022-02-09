@section('breadcrumb')
<!-- Breadcrumb -->
<div class="mt-5 mb-0 bg-white breadcrumb">
    <h5 class="px-5 my-2">
        @for ($i = 0; $i < count(Request::segments()); $i++) {{ strtoupper(Request::segment($i)) }} @if($i <
            count(Request::segments()) & $i> 0)
            <i class="fa fa-angle-right"></i>
            @endif
            @endfor
    </h5>
</div>
<!-- End Breadcrumb -->
@endsection