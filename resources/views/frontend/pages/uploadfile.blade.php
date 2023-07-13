@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-1x fa-upload"></i> อัพโหลดวิดีโอ/โปสเตอร์ <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div class="col-md-12 mx-auto table-responsive">
            <table class="dataTable table w-100">
                <thead>
                    <tr class="text-center">
                        <th style="width: 10%;">#</th>
                        <th style="width: auto;min-width: 200px;">รายละเอียดบทความ</th>
                        <th style="width: 20%;">ลิงค์วิดีโอ</th>
                        <th style="width: 150px;">ไฟล์ Poster</th>
                        <th style="width: 10%;">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $value)
                        <tr class="text-center">
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start">
                                <strong style="font-size: 12px" class="text-warning">
                                    รหัสบทความ : {{ $value->topic_id }}
                                </strong>
                                <br />
                                <strong>{!! $value->topic_th !!}</strong>
                                <br />
                                <strong><span class="name-research text-small text-green">ผู้นำเสนอ :
                                        {{ str_replace('!!', '', str_replace('ดร.', ' ดร.', str_replace('|', ', ', $value->presenter))) }}</span></strong>
                                <br />
                                <strong style="font-size: 12px" class="text-bluesky">
                                    รูปแบบบทความ : {{ $value->present }}
                                </strong>
                            </td>
                            <td>
                                @if (strtolower($value->present) == strtolower('Poster'))
                                    @if ($value->video_link)
                                        <a href="{{ $value->video_link }}">{{ $value->video_link }}</a>
                                    @endif
                                    @if ($value->status_poster_and_video)
                                        @if (endDate('end_poster_and_video')->day >= 0)
                                            @if ($value->video_link)
                                                <button
                                                    onclick="open_modal_poster_video('video', {{ $value->topic_id }}, '{{ $value->video_link }}')"
                                                    class="btn btn-link fw-bold px-4 mx-auto text-warning rounded-0 d-block my-2"><i
                                                        class="fas fa-edit"></i>
                                                    แก้ไขวิดีโอ</button>
                                            @else
                                                <a href="{{ $value->video_link }}">{{ $value->video_link }}</a>
                                                <button
                                                    onclick="open_modal_poster_video('video', {{ $value->topic_id }}, '{{ $value->video_link }}')"
                                                    class="btn btn-green px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                        class="fas fa-plus"></i>
                                                    เพิ่มวิดีโอ</button>
                                            @endif
                                        @else
                                            @if (!$value->video_link)
                                                <h1 class="text-danger text-center">
                                                    <strong style="font-size: calc(.1vw + 10px);">
                                                        หมดเวลาส่งวิดีโอ
                                                    </strong>
                                                </h1>
                                            @endif
                                            {{-- <strong class="text-red d-block">หมดเวลาส่งวิดีโอ</strong> --}}
                                        @endif
                                    @else
                                        -
                                    @endif
                                @else
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ต้องมีรูปแบบนำเสนอ Poster
                                        </strong>
                                    </h1>
                                @endif
                            </td>
                            <td>
                                @if (strtolower($value->present) == strtolower('Poster'))
                                    @if ($value->poster_name)
                                        <div onclick="open_modal_default('#modal', 'xl', 'โปสเตอร์', {{ $value }})"
                                            style="clip-path: inset(0px 0px);" class="card-body position-relative p-0">
                                            <div class="img-expand-hover">
                                                <i class="fas fa-2x fa-search-plus text-white"> <span
                                                        class="text-lg">ดูภาพขนาดใหญ่</span></i>
                                            </div>
                                            <img width="100%" src="{{ $value->poster_path }}"
                                                alt="{{ $value->topic_id }}">
                                        </div>
                                    @endif
                                    @if ($value->status_poster_and_video)
                                        @if (endDate('end_poster_and_video')->day >= 0)
                                            @if ($value->poster_name)
                                                <button
                                                    onclick="open_modal_poster_video('poster', {{ $value->topic_id }}, '{{ $value->poster_name }}')"
                                                    class="btn btn-link fw-bold px-4 mx-auto text-warning rounded-0 d-block my-2"><i
                                                        class="fas fa-edit"></i>
                                                    แก้ไข Poster</button>
                                            @else
                                                <button
                                                    onclick="open_modal_poster_video('poster', {{ $value->topic_id }}, '{{ $value->poster_name }}')"
                                                    class="btn btn-green px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                        class="fas fa-plus"></i>
                                                    เพิ่ม Poster</button>
                                            @endif
                                        @else
                                            @if (!$value->poster_name)
                                                <h1 class="text-danger text-center">
                                                    <strong style="font-size: calc(.1vw + 10px);">
                                                        หมดเวลาส่งโปสเตอร์
                                                    </strong>
                                                </h1>
                                            @endif
                                        @endif
                                    @else
                                        -
                                    @endif
                                @else
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ต้องมีรูปแบบนำเสนอ Poster
                                        </strong>
                                    </h1>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-green rounded-0 text-white"
                                    onclick="open_modal(this, 'detail')">
                                    รายละเอียด
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8">ไม่มีบทความของท่าน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
