@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header d-flex align-items-center justify-content-between w-100">
                <h1>รายการบทความ</h1>
                <div class="ms-auto">
                    <a href="{{ route('researchs.export') }}" class="btn btn-info rounded-0"><i
                            class="fas fa-file-export"></i>
                        Export to
                        Excel</a>
                </div>
            </div>
            <div class="panel">
                <div class="body">
                    <div class="input-group">
                        <label for="search">ค้นหาบทความ</label>
                        <input type="text" class="form-control" name="search" id="search"
                            placeholder="ค้นหาผ่านลำดับ, รายละเอียด, ปีที่ส่งผลงาน, ชนิดารเข้าร่วม, เวลา">
                    </div>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="list table responsive hover">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th>#</th>
                                <th class="text-start">รายละเอียดบทความ</th>
                                <th>ปีที่ส่งผลงาน</th>
                                <th>ชนิดการเข้าร่วม</th>
                                <th>เวลา</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($researchs as $key => $research)
                                <tr>
                                    <td class="text-center">{{ ++$key }}</td>
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
                                    <td class="text-center">{{ $research->year }}</td>
                                    <td class="text-center">
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
                                            {{ thaiDateFormat($research->created_at, true) }}</i>
                                        <br />
                                        <i style="font-size: 12px" class="text-info">แก้ไขล่าสุดเมื่อ
                                            {{ thaiDateFormat($research->updated_at, true) }}</i>
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.research.edit', $research->topic_id) }}"
                                            class=" text-warning"><i class="nav-icon fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="6">ไม่มีบทความ</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
