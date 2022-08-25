@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.poster.update', $present_poster->id) }}" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="topic_th" value="{{ $present_poster->topic_th }}">
                        <div class="col-md-12 mb-3">
                            <label>ชื่อบทความ:
                                <span id="topic"><span
                                        class="text-success">{{ $present_poster->topic_th }}</span></span>
                            </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="present_poster_id">รหัสการนำเสนอ</label>
                            <input value="{{ $present_poster->present_poster_id }}" type="text" name="present_poster_id"
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
                                    <option value="{{ $faculty->id }}" @if ($present_poster->present_poster_faculty_id == $faculty->id) selected @endif>
                                        {{ $faculty->name }}</option>
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
                        <div class="col-md-6 mb-3">
                            <label for="link">ลิงค์คลิปวิดีโอ</label>
                            <input value="{{ $present_poster->link }}" type="text" name="link" id="link"
                                class="form-control rounded-0 @error('link') is-invalid @enderror">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-warning text-white rounded-0"><i class="fa fa-save"></i> แก้ไข</button>
                        </div>
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
                                <th style="width: auto;">รายละเอียดบทความ</th>
                                <th style="width: 150px;" class="text-center">โปสเตอร์</th>
                                <th style="width: 5%;" class="text-right">แก้ไข</th>
                                <th style="width: 5%;">ลบ</th>
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
                                        <div onclick="open_modal_default('#modal', 'xl', 'โปสเตอร์', {{ $present_poster }})"
                                            style="clip-path: inset(0px 0px);" class="card-body position-relative p-0">
                                            <div class="img-expand-hover">
                                                <i class="fas fa-2x fa-search-plus text-white"> <span
                                                        class="text-sm">ดูภาพขนาดใหญ่</span></i>
                                            </div>
                                            <img width="100%" src="{{ $present_poster->path }}"
                                                alt="{{ $present_poster->topic_th }}">
                                        </div>
                                    </td>
                                    <td class="text-right"><a
                                            href="{{ route('backend.poster.edit', $present_poster->id) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $present_poster->present_poster_id }}', '{{ route('backend.poster.delete', $present_poster->id) }}')"
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
