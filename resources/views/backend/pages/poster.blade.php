@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.poster.store') }}" class="mb-3">
                    @csrf
                    <div class="col-md-4 mb-3">
                        <label for="topic_id">รหัสบทความ</label>
                        <input onkeyup="set_topic_id(this)" onblur="set_topic_id(this)" value="{{ old('topic_id') }}"
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
                        <label for="present_poster_id">รหัสการนำเสนอ</label>
                        <input value="{{ old('present_poster_id') }}" type="text" name="present_poster_id"
                            id="present_poster_id"
                            class="form-control rounded-0 @error('present_poster_id') is-invalid @enderror">
                        @error('present_poster_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
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
                    <div class="col-md-6 mb-3">
                        <label for="link">ลิงค์คลิปวิดีโอ</label>
                        <input value="{{ old('link') }}" type="text" name="link" id="link"
                            class="form-control rounded-0 @error('link') is-invalid @enderror">
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success rounded-0"><i class="fa fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>ผลงานนำเสนอ Poster</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 10%;">รหัสการนำเสนอ</th>
                                <th style="width: 60%;">รายละเอียดบทความ</th>
                                <th class="text-center">โปสเตอร์</th>
                                <th class="text-right">แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($present_posters as $key => $present_poster)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $present_poster->present_poster_id }}</strong></td>
                                    <td><strong class="text-green">{{ $present_poster->topic_th }}</strong><br />
                                        <strong class="text-warning text-sm">{{ $present_poster->name }}</strong><br />
                                        <a target="_blank" href="{{ $present_poster->link }}">
                                            <strong class="text-primary text-sm">{{ $present_poster->link }}</strong>
                                        </a>
                                    </td>
                                    <td>
                                        <img width="100%" src="{{ Storage::url($present_poster->path) }}" alt="poster">
                                    </td>
                                    <td class="text-right"><a href="{{ route('backend.line.edit', $present_poster->id) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $present_poster->topic_th }}', '{{ route('backend.poster.delete', $present_poster->id) }}')"
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
