@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="oral" class="bg-white text-blue p-5 my-5">
        @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
            @if (count($link_orals) > 0)
                <div class="inner-content-header">
                    <h4 class="text-center">ผลงานนำเสนอ Oral Presentation <br />
                        @if ($conference)
                            {{ $conference->name }}
                        @endif
                    </h4>
                    <h4 class="text-green py-3">
                        {{ config('app.name') }}
                    </h4>
                </div>

                <div>
                    <h1>ลิงค์นำเสนอ Oral Presentation</h1>
                </div>
                @forelse ($faculties as $key => $faculty)
                    <div class="animate fade-up my-5">
                        <div class="px-4 py-2 bg-green">
                            <strong class="text-white">
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
                                    @forelse ($link_orals as $link_oral)
                                        @if ($faculty->name == $link_oral->name)
                                            <tr class="text-start">
                                                <td>
                                                    <strong class="text-{{ $colors[$key] }}">ห้อง :
                                                        {{ $link_oral->room }}</strong><br />
                                                    <strong>
                                                        ลิงค์นำเสนอ : <a
                                                            href="{{ $link_oral->link }}">{{ $link_oral->link }}</a>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <div onclick="open_modal_default('#modal_oral', 'md', '{{ $link_oral->room }}', {{ $link_oral }})"
                                                        style="clip-path: inset(0px 0px);"
                                                        class="card-body position-relative p-0">
                                                        <div class="img-expand-hover">
                                                            <i class="fas fa-2x fa-search-plus text-white">
                                                                <span class="text-sm"> ดูภาพขนาดใหญ่</span></i>
                                                        </div>
                                                        <img width="100%" src="{{ $link_oral->path }}"
                                                            alt="{{ $link_oral->room }}">
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
                        ไม่มีลิงค์นำเสนอ Oral Presentation
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
