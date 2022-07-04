@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.download.update', $download->id) }}" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12 mb-3">
                        <label for="name">เพิ่มหัวข้อดาวน์โหลดไฟล์ <i style="font-size: 12px;" class="text-red">(เช่น
                                ดาวน์โหลดเทมเพลตงานประชุมวิชาการ)</i></label>
                        <input value="{{ $download->name }}" type="text" name="name" id="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6" id="upload-type">
                        <label class="d-block">ชนิดการอัพโหลด</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="download" id="link" value="link"
                                {{ $download->link ? 'checked' : '' }}>
                            <label class="form-check-label" for="link">
                                อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                    https://www.youtube.com)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input value="{{ $download->link }}" type="text" name="link_upload" id="link-upload"
                                class="form-control rounded-0">
                            @error('link_upload')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="download" id="file" value="file"
                                @if (isset($download->name_file)) checked @endif>
                            <label class="form-check-label" for="file">
                                อัพโหลดเป็นไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                    ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                            </label>
                        </div>
                        <div class="mb-3" style="position: relative">
                            <label class="label-type-file"
                                {{ $download->name_file ? '' : 'style=background-color:#e9ecef;cursor:default' }}
                                for="file-upload">{{ $download->name_file ? $download->name_file : 'ไม่ได้เลือกไฟล์ใด' }}</label>
                            <input onchange="getFileName(this)" type="file"
                                name="file_upload" id="file-upload" class="form-control d-none rounded-0"
                                @if (isset($download->name_file)) @else disabled @endif>
                        </div>


                    </div>
                    <div class="col-12">
                        <button class="btn btn-warning text-white rounded-0"><i class="fa fa-edit"></i> แก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>ไฟล์ดาวน์โหลด</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อไฟล์ดาวน์โหลด</th>
                                <th>Link</th>
                                <th>ไฟล์อัพโหลด</th>
                                <th>สร้างเมื่อ</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($downloads as $key => $download)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $download->name }} @if ($download->id == $id)
                                            <i class="text-warning">(กำลังแก้ไข)</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($download->link)
                                            <a target="_blank" href="{{ $download->link }}">{{ $download->link }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($download->name_file)
                                            <a target="_blank"
                                                href="{{ Storage::url($download->path_file) }}">{{ $download->name_file }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td><i class="text-info">{{ thaiDateFormat($download->created_at, true) }}</i></td>
                                    <td><a href="{{ route('backend.download.edit', $download->id) }}"
                                            class="text-warning"><i class="fa fa-edit"></i> แก้ไข</a></td>
                                    <td><a href="#" class="text-danger"><i class="fas fa-trash-alt"></i> ลบ</a></td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
