@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>รายการบทความ</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>รายละเอียดบทความ</th>
                                <th>ปีที่ส่งผลงาน</th>
                                <th>ชนิดการเข้าร่วม</th>
                                <th>เวลา</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($researchs as $key => $research)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            @if ($research->present_id == 1)
                                                Oral
                                            @else
                                                Poster
                                            @endif
                                        </strong>
                                        <br />
                                        <strong>
                                            {{ $research->topic_th }}@if ($research->user_id == auth()->user()->id)
                                                <i class="text-bluesky"> (ฉัน)</i>
                                            @endif
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px"
                                            class="text-green">{{ str_replace('|', ', ', $research->presenter) }}</strong>
                                            
                                    </td>
                                    <td>{{ $research->year }}</td>
                                    <td>
                                        <span class="text-success">
                                            @if ($research->person_attend == 'send')
                                                ลงทะเบียนส่งผลงาน
                                            @else
                                                ลงทะเบียนเข้าร่วมงานทั่วไป
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <i style="font-size: 12px" class="text-info">อัพโหลดเมื่อ
                                            {{ ThaiDateHelper::thaiDateFormat($research->created_at, true) }}</i>
                                        <br />
                                        <i style="font-size: 12px" class="text-info">แก้ไขล่าสุดเมื่อ
                                            {{ ThaiDateHelper::thaiDateFormat($research->updated_at, true) }}</i>
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.research.edit', $research->topic_id) }}"
                                            class=" text-warning"><i class="nav-icon fas fa-pen"></i>
                                            แก้ไข</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
