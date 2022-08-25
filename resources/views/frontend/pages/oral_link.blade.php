@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">ผลงานนำเสนอ Oral Presentation <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>การนำเสนอผลงาน Oral Presentation</h1>
        </div>
        <div id="oral" class="my-5">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
                        @if (count($link_orals) > 0)
                            @forelse ($faculties as $key => $faculty)
                                <div class="animate fade-up my-5 border border-{{ $colors[$key] }}">
                                    <div class="bg-{{ $colors[$key] }} p-4">
                                        <h1>
                                            <strong class="text-white"><i class="fas fa-book"></i>
                                                {{ $faculty->name }}
                                            </strong>
                                        </h1>
                                    </div>
                                    <div class="p-4 text-dark">
                                        <table style="color: inherit;" class="dataTable table w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 20%;">ห้อง</th>
                                                    <th style="width: 70%;">Link</th>
                                                    <th style="width: 10%;" class="text-center">QR Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($link_orals as $key => $link_oral)
                                                    @if ($faculty->name == $link_oral->name)
                                                        <tr class="text-center">
                                                            <td>{{ $link_oral->room }}</td>
                                                            <td>
                                                                <a href="{{ $link_oral->link }}">{{ $link_oral->link }}</a>
                                                            </td>
                                                            <td class="text-center">
                                                                <div onclick="open_modal_default('#modal_oral', 'md', '{{ $link_oral->room }}', {{ $link_oral }})"
                                                                    style="clip-path: inset(0px 0px);"
                                                                    class="card-body position-relative p-0">
                                                                    <div class="img-expand-hover">
                                                                        <i class="fas fa-2x fa-search-plus text-white">
                                                                            <span class="text-lg">ดูภาพขนาดใหญ่</span></i>
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
                            <div class="text-center h2 text-red">ไม่มีผลงานนำเสนอ Oral Presentation</div>
                        @endif
                    @else
                        <div class="text-center h2 text-red">ยังไม่เปิดใช้งาน</div>
                    @endif

                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->
    <div id="modal_oral"></div>
@endsection
