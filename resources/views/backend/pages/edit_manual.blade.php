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
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.manual.update', $manual->id) }}"
                    class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12 mb-3">
                        <label for="name">เพิ่มหัวข้อดาวน์โหลดไฟล์ <i style="font-size: 12px;" class="text-red">(เช่น
                                ดาวน์โหลดเทมเพลตงานประชุมวิชาการ)</i></label>
                        <input value="{{ $manual->name }}" type="text" name="name" id="name"
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
                                @if (old('download') !== null) @if (old('download') == 'link') checked @endif
                            @elseif(isset($manual->link)) checked @endif>
                            <label class="form-check-label" for="link">
                                อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                    https://www.youtube.com)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input value="{{ $manual->link }}" type="text" name="link_upload" id="link-upload"
                                class="form-control rounded-0 @error('link_upload') is-invalid @enderror"
                                @if (old('download') !== null) @if (old('download') == 'file') disabled @endif
                            @elseif(isset($manual->name_file)) disabled @endif>
                            @error('link_upload')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="download" id="file" value="file"
                                @if (old('download') !== null) @if (old('download') == 'file') checked @endif
                            @elseif(isset($manual->name_file)) checked @endif>
                            <label class="form-check-label" for="file">
                                อัพโหลดเป็นไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                    ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                            </label>
                        </div>
                        <div class="mb-3" style="position: relative">
                            <label class="label-type-file mb-0 @error('file_upload') is-invalid @enderror"
                                @if (old('download') !== null) @if (old('download') == 'link') style="background-color:#e9ecef;cursor:default" @endif
                            @elseif($manual->link) style="background-color:#e9ecef;cursor:default"
                                @endif
                                for="file-upload">{{ $manual->name_file ? $manual->name_file : 'ไม่ได้เลือกไฟล์ใด' }}</label>
                            <input type="hidden" value="{{ $manual->name_file }}" name="name_file" id="name_file">

                            <input onchange="get_file_name(this)" type="file" name="file_upload" id="file-upload"
                                class="form-control d-none rounded-0 @error('file_upload') is-invalid @enderror"
                                @if (old('download') !== null) @if (old('download') == 'link') disabled @endif
                            @elseif(!isset($manual->name_file)) disabled @endif>

                            @error('file_upload')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                    </div>
                    <div class="col-12">
                        <button onclick="thisDisabled(this)" class="btn btn-warning text-white rounded-0"><i class="fa fa-edit"></i> แก้ไข</button>
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
                                <th class="text-right">แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($manuals as $key => $manual)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td style="max-width: 250px;">{{ $manual->name }} @if ($manual->id == $id)
                                            <i class="text-warning">(กำลังแก้ไข)</i>
                                        @endif
                                    </td>
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
                                    <td><i class="text-info">{{ thaiDateFormat($manual->created_at, true) }}</i></td>
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
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
