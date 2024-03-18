@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="poster" class="row bg-white text-blue p-5 my-5">
        @if (isset($conference->status_present_poster) && $conference->status_present_poster == 1)
            <div class="inner-content-header">
                <h4 class="text-center fw-bold">ผลงานนำเสนอ Poster Presentation <br />
                    @if ($conference)
                        {{ $conference->name }}
                    @endif
                </h4>
                <h4 class="text-primary py-3">
                    {{ config('app.name') }}
                </h4>
            </div>

            <div>
                <h1>การนำเสนอผลงาน Poster Presentation</h1>
            </div>
            @forelse ($present_posters as $present_poster)
                <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                    <div style="width: 90%; height:100%;" class="animated fade-up card rounded-0 mx-auto">
                        <div class="card-content w-100 h-100">
                            <div class="card-header text-center bg-green rounded-0">
                                <h2>
                                    <strong style="font-size: calc(12px + .5vw);">
                                        {{ $present_poster->present_poster_id }}
                                    </strong>
                                </h2>
                            </div>
                            <div onclick="open_modal_default('#modal_poster', 'xl', 'โปสเตอร์', {{ $present_poster }})"
                                style="clip-path: inset(0px 0px);" class="card-body position-relative p-0">
                                <div class="img-expand-hover">
                                    <i class="fas fa-3x fa-search-plus text-white"> <span
                                            class="text-xl">ดูภาพขนาดใหญ่</span></i>
                                </div>
                                <img class="loading-lazy-img" width="100%" onload=""
                                    src="{{ $present_poster->path }}" alt="{{ $present_poster->topic_th }}" loading="lazy">
                            </div>
                            <div class="card-footer bg-white">
                                <strong>
                                    @if ($present_poster->link)
                                        <p>ลิงค์: <br /><a target="_blank"
                                                href="{{ $present_poster->link }}">{{ $present_poster->link }}</a>
                                        </p>
                                    @endif

                                    <p>ชื่อบทความ: <br />
                                        {!! $present_poster->topic_th !!}</p>
                                </strong>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h1 class="text-danger text-center">
                    <i class="fas fa-2x fa-times"></i><br />
                    <strong style="font-size: calc(.5vw + 10px);">
                        ไม่มีผลงานนำเสนอ Poster Presentation
                    </strong>
                </h1>
            @endforelse
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดให้ดูผลงานนำเสนอ
                </strong>
            </h1>
        @endif
    </div>
    <!-- End Content -->
    <div id="modal_poster"></div>
@endsection
