@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h2 class="text-center">รายชื่อบทความ <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>รายชื่อบทความ</h1>
        </div>
        <table class="dataTable table w-100">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;">รหัสบทความ</th>
                    <th style="width: 25%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 15%;">รูปแบบบทความ</th>
                    <th style="width: 15%;">กลุ่มคณะ</th>
                    <th style="width: 15%;">การชำระเงิน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($researchs as $research)
                    <tr class="text-center">
                        <td><strong>{{ $research->topic_id }}</strong></td>
                        <td class="text-start"><strong>
                                {{ $research->topic_th }}
                                <br /><span
                                    class="name-research text-small text-green">{{ str_replace('|', ', ', $research->presenter) }}</span>
                            </strong>
                        </td>
                        <td>{{ $research->present_name }}</td>
                        <td class="text-small text-green">{{ $research->faculty_name }}</td>
                        <td>
                            @if ($research->topic_status_id >= 4)
                                <span class="text-small text-green">ชำระเงินแล้ว</span>
                            @else
                                <span class="text-small text-warning">{{ $research->topic_status }}</span>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- End Content -->
@endsection
