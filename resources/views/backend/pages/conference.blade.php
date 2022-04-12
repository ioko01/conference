@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ route('backend.conference.store') }}" class="mb-3">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="topic">เพิ่มหัวข้อการประชุมวิชาการ</label>
                        <input value="{{ old('topic') }}" type="text" name="topic" id="topic"
                            class="form-control rounded-0 @error('topic') is-invalid @enderror">
                        @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="year">เพิ่มปีที่ประชุมวิชาการ (พ.ศ.)</label>
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
                            <input value="{{ old('start') }}" type="date" name="start" id="start"
                                class="form-control rounded-0 @error('start') is-invalid @enderror">
                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="final">วันสิ้นสุดจัดงานประชุม</label>
                            <input value="{{ old('final') }}" type="date" name="final" id="final"
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
                            <label for="start_research">วันที่เปิดรับบทความ</label>
                            <input value="{{ old('start_research') }}" type="date" name="start_research" id="start_research"
                                class="form-control rounded-0 @error('start_research') is-invalid @enderror">
                            @error('start_research')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research">วันสิ้นสุดการรับบทความ</label>
                            <input value="{{ old('end_research') }}" type="date" name="end_research" id="end_research"
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
                            <input value="{{ old('end_payment') }}" type="date" name="end_payment" id="end_payment"
                                class="form-control rounded-0 @error('end_payment') is-invalid @enderror">
                            @error('end_payment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_attend">วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน</label>
                            <input value="{{ old('end_attend') }}" type="date" name="end_attend" id="end_attend"
                                class="form-control rounded-0 @error('end_attend') is-invalid @enderror">
                            @error('end_attend')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row m-0">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research_edit">วันสิ้นสุดการรับบทความฉบับแก้ไข</label>
                            <input value="{{ old('end_research_edit') }}" type="date" name="end_research_edit" id="end_research_edit"
                                class="form-control rounded-0 @error('end_research_edit') is-invalid @enderror">
                            @error('end_research_edit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_research_edit_two">วันสิ้นสุดการรับบทความฉบับแก้ไข ครั้งที่ 2</label>
                            <input value="{{ old('end_research_edit_two') }}" type="date" name="end_research_edit_two" id="end_research_edit_two"
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
                            <label for="end_poster_and_video">วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ</label>
                            <input value="{{ old('end_poster_and_video') }}" type="date" name="end_poster_and_video" id="end_poster_and_video"
                                class="form-control rounded-0 @error('end_poster_and_video') is-invalid @enderror">
                            @error('end_poster_and_video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label for="end_poster_and_video_two">วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ ครั้งที่ 2</label>
                            <input value="{{ old('end_poster_and_video_two') }}" type="date" name="end_poster_and_video_two" id="end_poster_and_video_two"
                                class="form-control rounded-0 @error('end_poster_and_video_two') is-invalid @enderror">
                            @error('end_poster_and_video_two')
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
                            @foreach ($conferences as $key => $conference)
                                <tr class="bg-green">
                                    <th>#</th>
                                    <th>หัวข้อ</th>
                                    <th>ปี</th>
                                    <th>สถานะ</th>
                                </tr>
                                <tr class="text-xs">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $conference->name }}</td>
                                    <td>{{ $conference->year }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            @if ($conference->status == 0)
                                                <p class="text-red my-auto text-xs">ปิดการใช้งาน</p>
                                                <button value="1" name="change_status" id="change_status"
                                                    class="btn btn-link text-xs">
                                                    เปิดใช้งาน
                                                </button>
                                            @else
                                                <p class="text-green my-auto text-xs">กำลังใช้งานอยู่</p>
                                                <button value="0" name="change_status" id="change_status"
                                                    class="btn btn-link text-xs">
                                                    ปิดใช้งาน
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="bg-secondary text-sm">รายละเอียดเพิ่มเติม</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันเริ่ม - สิ้นสุดงานประชุมวิชาการ</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->start) }} - {{ thaiDateFormat($conference->final) }}</td>    
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันเริ่ม - สิ้นสุดการรับบทความ</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->start_research) }} - {{ thaiDateFormat($conference->end_research) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการชำระเงิน</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_payment) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_attend) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_research_edit) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 2</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_research_edit_two) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอครั้งที่ 1</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_poster_and_video) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-xs">วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอครั้งที่ 2</th>
                                    <td colspan="2" class="text-center text-xs">{{ thaiDateFormat($conference->end_poster_and_video_two) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
