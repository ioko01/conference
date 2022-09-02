@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="proceeding" class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h4 class="text-center">PROCEEDING <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>
        @if ($conference->status_proceeding == 1)
            @forelse ($topics as $topic)
                @if ($topic)
                    <div class="animate fade-up row">
                        <div class="col-md-6 mb-3">
                            <div class="border">
                                <div class="bg-green text-white p-3">
                                    <strong>{{ $topic }}</strong>
                                </div>
                                <div class="p-3 row">
                                    @forelse ($proceedings as $proceeding)
                                        @if ($proceeding->topic == $topic)
                                            @if ($proceeding->path)
                                                @if (in_array($proceeding->extension, ['jpg', 'jpeg', 'png', 'giff', 'webp']))
                                                    <div class="col-lg-4 col-md-5 col-sm-6 col-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-header">
                                                                    <strong>
                                                                        {{ $proceeding->name }}
                                                                    </strong>
                                                                </div>
                                                                <div class="card-body">
                                                                    <img class="img-fluid"
                                                                        src="{{ Storage::url($proceeding->path) }}"
                                                                        alt="{{ $proceeding->name }}">
                                                                    <a target="_blank"
                                                                        class="btn btn-green mt-3 text-white rounded-0"
                                                                        href="{{ Storage::url($proceeding->path) }}"
                                                                        download="{{ $proceeding->name }}">ดาวน์โหลด</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <strong class="d-inline mb-3">
                                                        <a target="_blank"
                                                            href="{{ Storage::url($proceeding->path) }}">- {{ $proceeding->name }}</a>
                                                    </strong>
                                                @endif
                                            @elseif($proceeding->link)
                                                <strong class="d-inline mb-3">
                                                    <a target="_blank"
                                                        href="{{ $proceeding->link }}">- {{ $proceeding->name }}</a>
                                                </strong>
                                            @endif
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        @else
            <h1 class="text-danger text-center">ยังไม่เปิดเผยแพร่ Proceedings</h1>
        @endif


    </div>
    <!-- End Content -->
@endsection
