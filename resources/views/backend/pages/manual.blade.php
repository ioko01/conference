@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header bg-green rounded-0">
                <strong>
                    <i class="nav-icon fas fa-book"></i> 
                    คู่มือ
                </strong>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.manual.store') }}" class="mb-3">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="name">เพิ่มหัวข้อ <i style="font-size: 12px;" class="text-red">(เช่น
                                คู่มือการส่งลิงค์คลิปวิดีโอสำหรับผู้ส่งบทความในรูปแบบโปสเตอร์)</i></label>
                        <input value="{{ old('name') }}" type="text" name="name" id="name"
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
                            @if (old('download') !== null) @if (old('download') == 'link') checked @endif @else
                                checked @endif>
                            <label class="form-check-label" for="link">
                                อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                    https://www.youtube.com)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="link_upload" id="link-upload"
                                class="form-control rounded-0 @error('link_upload') is-invalid @enderror"
                                @if (old('download') !== null) @if (old('download') == 'file') disabled @endif
                                @endif>
                            @error('link_upload')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="download" id="file" value="file"
                                @if (old('download') !== null) @if (old('download') == 'file') checked @endif
                                @endif>
                            <label class="form-check-label" for="file">
                                อัพโหลดเป็นไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                    ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="file_upload" id="file-upload"
                                class="form-control rounded-0 @error('file_upload') is-invalid @enderror"
                            @if (old('download') !== null) @if (old('download') == 'link') disabled @endif @else
                                disabled @endif accept=".pdf, .pptx, .docx, .doc, .jpg, .jpeg, .png">
                            @error('file_upload')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success rounded-0"><i class="fa fa-save"></i> บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>คู่มือ</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ชื่อคู่มือ</th>
                                <th>Link</th>
                                <th>ไฟล์อัพโหลด</th>
                                <th class="text-right">แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($manuals as $key => $manual)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td style="max-width: 250px;">{{ $manual->name }}</td>
                                    <td>
                                        @if ($manual->link)
                                            <a target="_blank" href="{{ $manual->link }}">{{ $manual->link }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($manual->name_file)
                                            <a target="_blank"
                                                href="{{ Storage::url($manual->path_file) }}">{{ $manual->name_file }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right"><a href="{{ route('backend.manual.edit', $manual->id) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $manual->name }}', '{{ route('backend.manual.delete', $manual->id) }}')"
                                            class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash-alt"></i>
                                            ลบ</button></td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="6">ไม่มีหัวข้อดาวน์โหลด</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
