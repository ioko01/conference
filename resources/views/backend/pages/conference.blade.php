@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('backend.conference.store') }}" class="mb-3">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="topic">เพิ่มหัวข้อการประชุมวิชาการ <i style="font-size: 12px;"
                                class="text-red">(ตัวอย่าง: งานประชุมวิชาการระดับชาติ ราชภัฏเลยวิชาการ มหาวิทยาลัยราชภัฏเลย
                                ครั้งที่ 1)</i></label>
                        <input value="{{ old('topic') }}" type="text" name="topic" id="topic"
                            class="form-control rounded-0 @error('topic') is-invalid @enderror">
                        @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="year">เพิ่มปีที่ประชุมวิชาการ (พ.ศ.) <i style="font-size: 12px;"
                                class="text-red">(ตัวอย่าง: 2565)</i></label>
                        <input value="{{ old('year') }}" type="number" name="year" id="year"
                            class="form-control rounded-0 @error('year') is-invalid @enderror">
                        @error('year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="start">วันที่เริ่มจัดงานประชุม</label>
                            <input onchange="get_min_date_value(this)" min="{{ date('Y-m-d\TH:i') }}"
                                value="{{ old('start') }}" type="datetime-local" name="start" id="start"
                                class="form-control rounded-0 @error('start') is-invalid @enderror">
                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="final">วันสิ้นสุดจัดงานประชุม</label>
                            <input onchange="get_max_date_value(this)" value="{{ old('final') }}" type="datetime-local"
                                name="final" id="final"
                                class="form-control rounded-0 @error('final') is-invalid @enderror">
                            @error('final')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research">วันสิ้นสุดการรับบทความ</label>
                            <input value="{{ old('end_research') }}" type="datetime-local" name="end_research"
                                id="end_research"
                                class="form-control rounded-0 @error('end_research') is-invalid @enderror">
                            @error('end_research')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_payment">วันสิ้นสุดการชำระเงิน</label>
                            <input value="{{ old('end_payment') }}" type="datetime-local" name="end_payment"
                                id="end_payment" class="form-control rounded-0 @error('end_payment') is-invalid @enderror">
                            @error('end_payment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="consideration">ประกาศผลพิจารณา</label>
                            <input value="{{ old('consideration') }}" type="datetime-local" name="consideration"
                                id="consideration"
                                class="form-control rounded-0 @error('consideration') is-invalid @enderror">
                            @error('consideration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research_edit">วันสิ้นสุดการรับบทความฉบับแก้ไข</label>
                            <input value="{{ old('end_research_edit') }}" type="datetime-local" name="end_research_edit"
                                id="end_research_edit"
                                class="form-control rounded-0 @error('end_research_edit') is-invalid @enderror">
                            @error('end_research_edit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research_edit_two">วันสิ้นสุดการรับบทความฉบับแก้ไข ครั้งที่ 2 <span
                                    class="text-red">(อาจได้ใช้)</span></label>
                            <input value="{{ old('end_research_edit_two') }}" type="datetime-local"
                                name="end_research_edit_two" id="end_research_edit_two"
                                class="form-control rounded-0 @error('end_research_edit_two') is-invalid @enderror">
                            @error('end_research_edit_two')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_attend">วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน</label>
                            <input value="{{ old('end_attend') }}" type="datetime-local" name="end_attend"
                                id="end_attend" class="form-control rounded-0 @error('end_attend') is-invalid @enderror">
                            @error('end_attend')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_poster_and_video">วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ</label>
                            <input value="{{ old('end_poster_and_video') }}" type="datetime-local"
                                name="end_poster_and_video" id="end_poster_and_video"
                                class="form-control rounded-0 @error('end_poster_and_video') is-invalid @enderror">
                            @error('end_poster_and_video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="notice_attend">ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด</label>
                            <input value="{{ old('notice_attend') }}" type="datetime-local" name="notice_attend"
                                id="notice_attend"
                                class="form-control rounded-0 @error('notice_attend') is-invalid @enderror">
                            @error('notice_attend')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="present">นำเสนอผลงาน</label>
                            <input value="{{ old('present') }}" type="datetime-local" name="present" id="present"
                                class="form-control rounded-0 @error('present') is-invalid @enderror">
                            @error('present')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="proceeding">เผยแพร่ Proceeding</label>
                            <input value="{{ old('proceeding') }}" type="datetime-local" name="proceeding"
                                id="proceeding" class="form-control rounded-0 @error('proceeding') is-invalid @enderror">
                            @error('proceeding')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success rounded-0">เพิ่มหัวข้อ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>หัวข้อการประชุมวิชาการ</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">ตารางหัวข้อการประชุมวิชาการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($conferences as $key => $conference)
                                <tr class="bg-green">
                                    <th>#</th>
                                    <th>หัวข้อ</th>
                                    <th>ปี (พ.ศ.)</th>
                                    <th>แก้ไข</th>
                                </tr>
                                <tr class="text-xs"
                                    style="background-color:@if ($conference->status == 1) #c3f6ce;@else #ffc2c2; @endif">
                                    <th>{{ ++$key }}</th>
                                    <th>{{ $conference->name }}</th>
                                    <th>{{ $conference->year }}</th>
                                    <th><a href="{{ route('backend.conference.edit', ['conference_id' => $conference->id]) }}"
                                            class="text-primary"><i class="fa fa-edit"></i> แก้ไข</a></th>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-secondary text-sm">รายละเอียดเพิ่มเติม</td>
                                </tr>
                                <tr>
                                    <td>วันเริ่ม - สิ้นสุดงานประชุมวิชาการ <br /><span
                                            class="text-red text-xs fw-bold">คำแนะนำ:
                                            ต้องเปิดหัวข้อนี้ก่อนถึงจะเปิดใช้งานหัวข้ออื่นได้</span>
                                    </td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->start) }} -
                                        {{ thaiDateFormat($conference->final) }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_conference_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_conference_{{ $key }}"
                                                    @if ($conference->status == 1) checked @endif>

                                                @if ($conference->status == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_conference_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_conference_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_conference_{{ $key }}"
                                                name="change_status_conference"
                                                @if ($conference->status == 1) value=0 @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>สิ้นสุดการรับบทความ</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->end_research) }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_research_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_research_{{ $key }}"
                                                    @if ($conference->status_research == 1) checked @endif>

                                                @if ($conference->status_research == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_research_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_research_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_research_{{ $key }}" name="change_status_research"
                                                @if ($conference->status_research == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันสิ้นสุดการชำระค่าลงทะเบียน</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->end_payment) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_payment_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_payment_{{ $key }}"
                                                    @if ($conference->status_payment == 1) checked @endif>

                                                @if ($conference->status_payment == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_payment_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_payment_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none" id="change_payment_{{ $key }}"
                                                name="change_status_payment"
                                                @if ($conference->status_payment == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ประกาศผลพิจารณา</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->consideration) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_consideration{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_consideration{{ $key }}"
                                                    @if ($conference->status_consideration == 1) checked @endif>

                                                @if ($conference->status_consideration == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_consideration{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_consideration{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_consideration{{ $key }}"
                                                name="change_status_consideration"
                                                @if ($conference->status_consideration == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->end_research_edit) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_research_edit_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_research_edit_{{ $key }}"
                                                    @if ($conference->status_research_edit == 1) checked @endif>

                                                @if ($conference->status_research_edit == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_research_edit_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_research_edit_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_research_edit_{{ $key }}"
                                                name="change_status_research_edit"
                                                @if ($conference->status_research_edit == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 2 <br /><span
                                            class="text-red text-xs fw-bold">คำแนะนำ:
                                            ควรปิดใช้งานวันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1 ก่อน</span></td>
                                    <td colspan="2" class="text-left text-xs">
                                        @if ($conference->end_research_edit_two)
                                            {{ thaiDateFormat($conference->end_research_edit_two) }}
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_research_edit_two_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_research_edit_two_{{ $key }}"
                                                    @if ($conference->status_research_edit_two == 1) checked @endif>

                                                @if ($conference->status_research_edit_two == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_research_edit_two_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_research_edit_two_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_research_edit_two_{{ $key }}"
                                                name="change_status_research_edit_two"
                                                @if ($conference->status_research_edit_two == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->end_attend) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_attend_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_attend_{{ $key }}"
                                                    @if ($conference->status_attend == 1) checked @endif>

                                                @if ($conference->status_attend == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_attend_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_attend_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none" id="change_attend_{{ $key }}"
                                                name="change_status_attend"
                                                @if ($conference->status_attend == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->end_poster_and_video) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_poster_and_video_{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_poster_and_video_{{ $key }}"
                                                    @if ($conference->status_poster_and_video == 1) checked @endif>

                                                @if ($conference->status_poster_and_video == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_poster_and_video_{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_poster_and_video_{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_poster_and_video_{{ $key }}"
                                                name="change_status_poster_and_video"
                                                @if ($conference->status_poster_and_video == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ผลงานนำเสนอ Poster<br /><span class="text-red text-xs fw-bold">คำแนะนำ:
                                            เปิดใช้งานเมื่อต้องการแสดงผลงานนำเสนอ Poster</span></td>
                                    <td colspan="2" class="text-left text-xs">-</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_present_poster{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_present_poster{{ $key }}"
                                                    @if ($conference->status_present_poster == 1) checked @endif>

                                                @if ($conference->status_present_poster == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_present_poster{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_present_poster{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_present_poster{{ $key }}"
                                                name="change_status_present_poster"
                                                @if ($conference->status_present_poster == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->notice_attend) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_notice_attend{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_notice_attend{{ $key }}"
                                                    @if ($conference->status_notice_attend == 1) checked @endif>

                                                @if ($conference->status_notice_attend == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_notice_attend{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_notice_attend{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_notice_attend{{ $key }}"
                                                name="change_status_notice_attend"
                                                @if ($conference->status_notice_attend == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>นำเสนอผลงาน</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->present) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_present{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_present{{ $key }}"
                                                    @if ($conference->status_present == 1) checked @endif>

                                                @if ($conference->status_present == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_present{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_present{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none" id="change_present{{ $key }}"
                                                name="change_status_present"
                                                @if ($conference->status_present == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>เผยแพร่ Proceedings</td>
                                    <td colspan="2" class="text-left text-xs">
                                        {{ thaiDateFormat($conference->proceeding) }}
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update_status', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="custom-control custom-switch">
                                                <input
                                                    onchange="javascript:document.getElementById('change_proceeding{{ $key }}').click()"
                                                    type="checkbox" class="custom-control-input"
                                                    id="switch_proceeding{{ $key }}"
                                                    @if ($conference->status_proceeding == 1) checked @endif>

                                                @if ($conference->status_proceeding == 1)
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-success"
                                                        for="switch_proceeding{{ $key }}">เปิดใช้งานอยู่</label>
                                                @else
                                                    <label style="font-size: 10px;"
                                                        class="custom-control-label text-danger"
                                                        for="switch_proceeding{{ $key }}">ปิดใช้งาน</label>
                                                @endif
                                            </div>
                                            <input type="submit" class="d-none"
                                                id="change_proceeding{{ $key }}"
                                                name="change_status_proceeding"
                                                @if ($conference->status_proceeding == 1) value=0
                                    @else
                                    value=1 @endif>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4">ไม่มีหัวข้อการประชุมวิชาการ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
