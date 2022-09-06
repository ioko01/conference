@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header bg-green rounded-0">
                <strong>
                    ผลงานนำเสนอ Oral
                </strong>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.oral.store') }}" class="mb-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="topic_id">รหัสบทความ</label>
                            <input onkeyup="present_oral(this)" onblur="present_oral(this)" value="{{ old('topic_id') }}"
                                type="text" name="topic_id" id="topic_id"
                                class="form-control rounded-0 @error('topic_id') is-invalid @enderror">
                            @error('topic_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div id="topic_content"></div>
                        <div class="col-md-12 mb-3">
                            <label>ชื่อบทความ:
                                <span id="topic"><span class="text-red">กรุณากรอกรหัสบทความ</span></span>
                            </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="present_oral_id">รหัสการนำเสนอ</label>
                            <input value="{{ old('present_oral_id') }}" type="text" name="present_oral_id"
                                id="present_oral_id"
                                class="form-control rounded-0 @error('present_oral_id') is-invalid @enderror">
                            @error('present_oral_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 mb-3">
                            <label for="time_start">เวลาเริ่มการนำเสนอ</label>
                            <input value="{{ old('time_start') }}" type="time" name="time_start" id="time_start"
                                class="form-control rounded-0 @error('time_start') is-invalid @enderror">
                            @error('time_start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 mb-3">
                            <label for="time_end">เวลาสิ้นสุดการนำเสนอ</label>
                            <input value="{{ old('time_end') }}" type="time" name="time_end" id="time_end"
                                class="form-control rounded-0 @error('time_end') is-invalid @enderror">
                            @error('time_end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="faculty_id">กลุ่มบทความ</label>
                            <select name="faculty_id" id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                                @forelse ($faculties as $faculty)
                                    @if ($loop->first)
                                        <option value="">-- เลือกกลุ่มบทความ --</option>
                                    @endif
                                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                @empty
                                    <option value="">ไม่มีกลุ่ม</option>
                                @endforelse
                            </select>
                            @error('faculty_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button onclick="thisDisabled(this)" class="btn btn-success rounded-0"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>ผลงานนำเสนอ Oral</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 10%;">รหัสการนำเสนอ</th>
                                <th style="width: auto;">รายละเอียดบทความ</th>
                                <th style="width: 15%;" class="text-center">เวลาในการนำเสนอ</th>
                                <th style="width: 5%;" class="text-right">แก้ไข</th>
                                <th style="width: 5%;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($present_orals as $key => $present_oral)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $present_oral->present_oral_id }}</strong></td>
                                    <td><strong class="text-green">{{ $present_oral->topic_th }}</strong><br />
                                        <strong class="text-warning text-sm">{{ $present_oral->name }}</strong><br />
                                    </td>
                                    <td class="text-center"><strong
                                            class="text-green">{{ substr($present_oral->time_start, 0, -3) }} -
                                            {{ substr($present_oral->time_end, 0, -3) }} น.</strong>
                                    </td>
                                    <td class="text-right"><a href="{{ route('backend.oral.edit', $present_oral->id) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $present_oral->present_oral_id }}', '{{ route('backend.oral.delete', $present_oral->id) }}')"
                                            class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash-alt"></i>
                                            ลบ</button></td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
