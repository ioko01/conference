@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
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
        <div id="oral" class="row my-5">
            <div class="col-md-7">
                @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
                    @if (count($link_orals) > 0)
                        @forelse ($faculties as $key => $faculty)
                            <div class="animate fade-up my-5">
                                <div class="px-4">
                                    <h1>
                                        <strong style="font-size: calc(12px + .5vw);" class="text-{{ $colors[$key] }}"><i
                                                class="fas fa-book fa-1x"></i>
                                            {{ $faculty->name }}
                                        </strong>
                                    </h1>
                                </div>
                                <div class="px-4 text-dark">
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
                        <div class="text-center h2 text-red">ไม่มีลิงค์นำเสนอ Oral Presentation</div>
                    @endif
                @else
                    <div class="text-center h2 text-red">ยังไม่เปิดใช้งาน</div>
                @endif
            </div>
            <div class="col-md-5 tips justify-content-start">
                <div class="tips-content">
                    @foreach ($tips as $tip)
                        <div class="tips-box py-5">
                            <div class="icon"><img src="{{ asset($tip->image, env('REDIRECT_HTTPS')) }}"
                                    alt="{{ $tip->head }}">
                            </div>
                            <div class="content"><strong>{{ $tip->head }}</strong><br /><span>
                                    <textarea readonly style="width: 100%;" class="txt-tips autosize">{{ $tip->detail }}</textarea>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- End Content -->
    <div id="modal_oral"></div>
@endsection
