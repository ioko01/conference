@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="poster" class="bg-white text-blue p-5 my-5">
        @if (isset($conference->status_present_poster) && $conference->status_present_poster == 1)
            @if (count($present_posters) > 0)
                <div class="inner-content-header">
                    <h4 class="text-center">กำหนดการนำเสนอ Poster Presentation <br />
                        @if ($conference)
                            {{ $conference->name }}
                        @endif
                    </h4>
                    <h4 class="text-primary py-3">
                        {{ config('app.name') }}
                    </h4>
                </div>

                <div>
                    <h1>กำหนดการการนำเสนอผลงาน Poster Presentation</h1>
                    <a href="/posters/link" class="h1 text-green"> >> คลิ๊กที่นี่เพื่อตรวจสอบห้องนำเสนอผลงาน Poster Presentation <<</a>
                </div>
                @forelse ($faculties as $key => $faculty)
                    <div class="animate fade-up my-5">
                        <div style="background-color: {{ $colors[$faculty->id] }};color:{{ $textColors[$faculty->id] }};" class="px-4 py-2">
                            <strong>
                                {{ $faculty->name }}
                            </strong>
                        </div>
                        <div class="p-4 text-dark table-responsive">
                            <table data-searching="false" style="color: inherit;" class="dataTable table w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th style="display: none;">#</th>
                                        <th style="width: 15%;">รหัสการนำเสนอ</th>
                                        <th style="width: 20%;">เวลา</th>
                                        <th style="width: auto%;" class="text-start">ชื่อบทความ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($present_posters as $key => $present_poster)
                                        @if ($faculty->name == $present_poster->name)
                                            <tr class="text-center">
                                                <td style="display: none;">{{ $key + 1 }}</td>
                                                <td>{{ $present_poster->present_poster_id }}</td>
                                                <td>{{ substr($present_poster->time_start, 0, -3) }} -
                                                    {{ substr($present_poster->time_end, 0, -3) }} น.</td>
                                                <td class="text-start">{!! $present_poster->topic_th !!}
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
                        ไม่มีกำหนดการนำเสนอ Poster Presentation
                    </strong>
                </h1>
            @endif
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดให้ดูกำหนดการนำเสนอ
                </strong>
            </h1>
        @endif
    </div>
    </div>
    <!-- End Content -->
    <div id="modal_poster"></div>
@endsection
