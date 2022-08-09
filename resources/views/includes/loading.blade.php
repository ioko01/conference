
@section('loading')
<div id="loading">
    <div class="loading-content">
        <div class="loading-circle"></div>
        <div class="d-flex justify-content-center align-items-center w-100 h-100">
            <img loading="lazy" class="loading-image" src="{{ asset('images/lru.webp', env('REDIRECT_HTTPS')) }}" alt="loader">
        </div>
    </div>
</div>
@endsection