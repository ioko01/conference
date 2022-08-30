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
            <h1>การนำเสนอผลงาน Oral Presentation</h1>
        </div>
        <div id="oral" class="row my-5">
            <div class="col-md-7">
                @if (isset($conference->status_present_oral) && $conference->status_present_oral == 1)
                    @if (count($present_orals) > 0)
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
                        <div class="text-center h2 text-red">ไม่มีผลงานนำเสนอ Oral Presentation</div>
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
