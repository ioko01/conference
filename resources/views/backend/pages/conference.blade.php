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
                        <div class="col-md-3 mb-3">
                            <label for="year">วันที่เริ่ม</label>
                            <input value="{{ old('start') }}" type="date" name="start" id="start"
                                class="form-control rounded-0 @error('start') is-invalid @enderror">
                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="year">วันสิ้นสุด</label>
                            <input value="{{ old('end') }}" type="date" name="end" id="end"
                                class="form-control rounded-0 @error('end') is-invalid @enderror">
                            @error('end')
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>หัวข้อ</th>
                                <th>ปี (พ.ศ.)</th>
                                <th class="text-center">เริ่ม</th>
                                <th class="text-center">สิ้นสุด</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conferences as $key => $conference)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $conference->name }}</td>
                                    <td>{{ $conference->year }}</td>
                                    <td class="text-center">{{ thaiDateFormat($conference->start) }}</td>
                                    <td class="text-center">{{ thaiDateFormat($conference->end) }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('backend.conference.update', $conference->id) }}"
                                            class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            @if ($conference->status == 0)
                                                <p class="text-red my-auto">ปิดการใช้งาน</p>
                                                <button value="1" name="change_status" id="change_status"
                                                    class="btn btn-link">
                                                    เปิดใช้งาน
                                                </button>
                                            @else
                                                <p class="text-green my-auto">กำลังใช้งานอยู่</p>
                                                <button value="0" name="change_status" id="change_status"
                                                    class="btn btn-link">
                                                    ปิดใช้งาน
                                                </button>
                                            @endif
                                        </form>
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
