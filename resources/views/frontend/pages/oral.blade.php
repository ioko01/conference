@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div id="oral" class="bg-white text-blue p-5 my-5">
        @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
            @if (count($present_orals) > 0)
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
                    <h1>การนำเสนอผลงาน Oral Presentation</h1>
                </div>
                @forelse ($faculties as $key => $faculty)
                    <div class="animate fade-up my-5">
                        <div class="px-4 py-2 bg-green">
                            <strong class="text-white">
                                {{ $faculty->name }}
                            </strong>
                        </div>
                        <div class="p-4 text-dark">
                            <table data-searching="false" style="color: inherit;" class="dataTable table w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 15%;">รหัสการนำเสนอ</th>
                                        <th style="width: 20%;">เวลา</th>
                                        <th style="width: auto%;" class="text-start">ชื่อบทความ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($present_orals as $key => $present_oral)
                                        @if ($faculty->name == $present_oral->name)
                                            <tr class="text-center">
                                                <td>{{ $present_oral->present_oral_id }}</td>
                                                <td>{{ substr($present_oral->time_start, 0, -3) }} -
                                                    {{ substr($present_oral->time_end, 0, -3) }} น.</td>
                                                <td class="text-start">{{ $present_oral->topic_th }}
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
                        ไม่มีผลงานนำเสนอ Oral Presentation
                    </strong>
                </h1>
            @endif
        @else
            <h1 class="text-danger text-center">
                <i class="fas fa-2x fa-times"></i><br />
                <strong style="font-size: calc(.5vw + 10px);">
                    ยังไม่เปิดให้ดูผลงานนำเสนอ
                </strong>
            </h1>
        @endif
    </div>
    </div>
    <!-- End Content -->
    <div id="modal_oral"></div>
@endsection
