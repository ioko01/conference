@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">ผลงานนำเสนอ Poster Presentation <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>การนำเสนอผลงาน Poster Presentation</h1>
        </div>

        <div id="poster" class="row my-5">
            @if ($conference->status_present_poster == 1)
                @forelse ($present_posters as $present_poster)
                    <div class="col-lg-2 col-md-4 col-sm-6 my-3">
                        <div style="width: 90%;" class="animated fade-up card rounded-0 mx-auto">
                            <div class="card-content w-100 h-100">
                                <div class="card-header text-center bg-white">
                                    <h2>{{ $present_poster->present_poster_id }}</h2>
                                </div>
                                <div onclick="open_modal_default('#modal_poster', 'xl', 'โปสเตอร์', {{ $present_poster }})"
                                    style="clip-path: inset(0px 0px);" class="card-body position-relative p-0">
                                    <div class="img-expand-hover">
                                        <i class="fas fa-3x fa-search-plus text-white"> <span
                                                class="text-xl">ดูภาพขนาดใหญ่</span></i>
                                    </div>
                                    <img width="100%" src="{{ $present_poster->path }}"
                                        alt="{{ $present_poster->topic_th }}">
                                </div>
                                <div class="card-footer bg-white">
                                    <p>ลิงค์: <br /><a target="_blank"
                                            href="{{ $present_poster->link }}">{{ $present_poster->link }}</a>
                                    </p>
                                    <p>ชื่อบทความ: <br />
                                        {{ $present_poster->topic_th }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center h2 text-red">ไม่มีผลงานนำเสนอ Poster Presentation</div>
                @endforelse
            @else
                <div class="text-center h2 text-red">ยังไม่เปิดใช้งาน</div>
            @endif


        </div>

    </div>
    <!-- End Content -->
    <div id="modal_poster"></div>
@endsection
