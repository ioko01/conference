
@section('loading')
<div id="loading">
    <div class="loading-content">
        <div class="loading-circle"></div>
        <div class="d-flex justify-content-center align-items-center w-100 h-100">
            <img class="loading-image" src="{{ secure_asset('images/loading.png') }}" alt="loader">
        </div>
    </div>
</div>
@endsection