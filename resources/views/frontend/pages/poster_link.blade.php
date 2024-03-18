@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="oral" class="bg-white text-blue p-5 my-5">
        @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
            @if (count($link_posters) > 0)
                <div class="inner-content-header">
                    <h4 class="text-center">ผลงานนำเสนอ Poster Presentation <br />
                        @if ($conference)
                            {{ $conference->name }}
                        @endif
                    </h4>
                    <h4 class="text-primary py-3">
                        {{ config('app.name') }}
                    </h4>
                </div>

                <div>
                    <h1>ลิงค์นำเสนอ Poster Presentation</h1>
                    <a href="/posters/schedule" class="h1 text-green"> >> คลิ๊กที่นี่เพื่อตรวจสอบกำหนดการเสนอผลงาน Poster Presentation <<</a>
                </div>
                @forelse ($faculties as $key => $faculty)
                    <div class="animate fade-up my-5">
                        <div style="background-color: {{ $colors[$faculty->id] }};color:{{ $textColors[$faculty->id] }};" class="px-4 py-2">
                            <strong>
                                {{ $faculty->name }}
                            </strong>
                        </div>
                        <div class="px-4 text-dark table-responsive">
                            <table data-searching="false" style="color: inherit;" class="dataTable table w-100">
                                <thead>
                                    <tr class="text-start">
                                        <th style="width: auto;"></th>
                                        <th style="width: 10%;" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($link_posters as $link_poster)
                                        @if ($faculty->name == $link_poster->name)
                                            <tr class="text-start">
                                                <td>
                                                    <strong class="px-2"
                                                        style="background-color: {{ $colors[$faculty->id] }};color:{{ $textColors[$faculty->id] }};">ห้อง
                                                        :
                                                        {{ $link_poster->room }}</strong><br />
                                                    <strong>
                                                        ลิงค์นำเสนอ : <a
                                                            href="{{ $link_poster->link }}">{{ $link_poster->link }}</a>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <div onclick="open_modal_default('#modal_oral', 'md', '{{ $link_poster->room }}', {{ $link_poster }})"
                                                        style="clip-path: inset(0px 0px);"
                                                        class="card-body position-relative p-0">
                                                        <div class="img-expand-hover">
                                                            <i class="fas fa-2x fa-search-plus text-white">
                                                                <span class="text-sm"> ดูภาพขนาดใหญ่</span></i>
                                                        </div>
                                                        <img width="100%" src="{{ $link_poster->path }}"
                                                            alt="{{ $link_poster->room }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="4">ไม่มีบทความ</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                @empty
                @endforelse
            @else
                <h1 class="text-danger text-center">
                    <i class="fas fa-2x fa-times"></i><br />
                    <strong style="font-size: calc(.5vw + 10px);">
                        ไม่มีลิงค์นำเสนอ Poster Presentation
                    </strong>
                </h1>
            @endif
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดให้ดูลิงค์นำเสนอ
                </strong>
            </h1>
        @endif
    </div>
    <!-- End Content -->
    <div id="modal_oral"></div>
@endsection
