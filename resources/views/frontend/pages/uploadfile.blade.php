@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h2 class="text-center">อัพโหลดวิดีโอ/โปสเตอร์ <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>อัพโหลดวิดีโอ/โปสเตอร์</h1>
        </div>
        <div class="panel">
            <div class="body">
                <div class="input-group">
                    <label for="search">ค้นหาบทความ</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="ค้นหาบทความ">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="list table responsive hover">
                <thead>
                    <tr class="text-center pagination-header">
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;min-width: 200px;">รายละเอียดบทความ</th>
                        <th style="width: 15%;">ลิงค์วิดีโอ</th>
                        <th style="width: 10%;">ไฟล์ Poster</th>
                        <th style="width: 5%;">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $value)
                        <tr class="text-center">
                            <td style="vertical-align: middle;">{{ $key + 1 }}</td>
                            <td class="text-start" style="vertical-align: middle;">
                                <strong style="font-size: 12px" class="text-bluesky">{{ $value->present }}</strong>
                                <br />
                                <strong>{{ $value->topic_th }}</strong>
                                <br />
                                <strong><span
                                        class="name-research text-small text-green">{{ str_replace('|', ', ', $value->presenter) }}</span></strong>
                            </td>

                            <td>
                                @if ($value->video_link)
                                    <a href="{{ $value->video_link }}">{{ $value->video_link }}</a>
                                @endif
                                @if ($value->status_poster_and_video)
                                    @if (endDate('end_poster_and_video')->day >= 0)
                                        @if ($value->video_link)
                                            <button
                                                onclick="open_modal_poster_video('video', {{ $value->topic_id }}, '{{ $value->video_link }}')"
                                                class="btn btn-warning px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                    class="fas fa-edit"></i>
                                                แก้ไขลิงค์วิดีโอ</button>
                                        @else
                                            <a href="{{ $value->video_link }}">{{ $value->video_link }}</a>
                                            <button
                                                onclick="open_modal_poster_video('video', {{ $value->topic_id }}, '{{ $value->video_link }}')"
                                                class="btn btn-green px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                    class="fas fa-plus"></i>
                                                เพิ่มลิงค์วิดีโอ</button>
                                        @endif
                                    @else
                                        <strong class="text-red d-block">หมดเวลาส่งลิงค์วิดีโอ</strong>
                                    @endif
                                @else
                                    <strong class="text-red d-block">ไม่สามารถส่งลิงค์วิดีโอได้</strong>
                                @endif

                            </td>
                            <td>
                                @if ($value->poster_name)
                                    <a download="POSTER_{{ $value->poster_name }}" target="_blank"
                                        class="btn btn-info px-4 mx-auto text-white rounded-0 my-2"
                                        href="{{ Storage::url($value->poster_path) }}"><i class="fas fa-download"></i>
                                        ดาวน์โหลดไฟล์ Poster</a>
                                @endif
                                @if ($value->status_poster_and_video)
                                    @if (endDate('end_poster_and_video')->day >= 0)
                                        @if ($value->poster_name)
                                            <button
                                                onclick="open_modal_poster_video('poster', {{ $value->topic_id }}, '{{ $value->poster_name }}')"
                                                class="btn btn-warning px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                    class="fas fa-edit"></i>
                                                แก้ไขไฟล์ Poster</button>
                                        @else
                                            <button
                                                onclick="open_modal_poster_video('poster', {{ $value->topic_id }}, '{{ $value->poster_name }}')"
                                                class="btn btn-green px-4 mx-auto text-white rounded-0 d-block my-2"><i
                                                    class="fas fa-plus"></i>
                                                เพิ่มไฟล์ Poster</button>
                                        @endif
                                    @else
                                        <strong class="text-red d-block">หมดเวลาส่งลิงค์วิดีโอ</strong>
                                    @endif
                                @else
                                    <strong class="text-red d-block">ไม่สามารถส่งโปสเตอร์ได้</strong>
                                @endif
                            </td>
                            <td style="vertical-align: middle;">
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
