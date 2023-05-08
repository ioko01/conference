@extends('backend.layouts.master_backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-green p-3">
                <strong>PROCEEDINGS {{ $year }}</strong>
            </div>
            <div class="card rounded-0">
                <div class="card-content rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="list-group rounded-0">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.topic.index', $year) }}">
                                                <span><i class="fas fa-plus"></i></span> เพิ่มหัวข้อ Proceedings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                                href="{{ route('backend.proceeding.file.index', $year) }}">
                                                <span><i class="fas fa-file-upload"></i></span> อัพโหลดไฟล์ Proceedings
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.research.index', $year) }}">
                                                <span><i class="fas fa-book"></i></span> อัพโหลดบทความ Proceedings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-primary"
                                                href="{{ route('backend.proceeding.preview.index', $year) }}">
                                                <span><i class="fas fa-eye"></i></span> แสดงตัวอย่าง</a>
                                        </li>
                                        <li class="ml-auto align-self-center">
                                            <form method="POST"
                                                action="{{ route('backend.conference.update_status', $conference->id) }}"
                                                class="d-flex">
                                                @csrf
                                                @method('PUT')
                                                <div class="custom-control custom-switch">
                                                    <input
                                                        onchange="javascript:document.getElementById('change_proceeding1').click()"
                                                        type="checkbox" class="custom-control-input" id="switch_proceeding1"
                                                        @if ($conference->status_proceeding == 1) checked @endif>

                                                    @if ($conference->status_proceeding == 1)
                                                        <label style="font-size: 10px;"
                                                            class="custom-control-label text-success"
                                                            for="switch_proceeding1">เผยแพร่ Proceedings แล้ว</label>
                                                    @else
                                                        <label style="font-size: 10px;"
                                                            class="custom-control-label text-danger"
                                                            for="switch_proceeding1">ยังไม่ได้เผยแพร่ Proceedings</label>
                                                    @endif
                                                </div>
                                                <input type="submit" class="d-none" id="change_proceeding1"
                                                    name="change_status_proceeding"
                                                    @if ($conference->status_proceeding == 1) value=0
                                    @else
                                    value=1 @endif>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form action="{{ route('backend.proceeding.file.store', $year) }}" enctype="multipart/form-data"
                                method="POST" class="col-md-12">
                                @csrf
                                <div class="border border-top-0 p-3">
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="topic_id">หัวข้อ <span class="text-red text-sm">(เช่น : หน้าปก,
                                                    ส่วนหน้า,
                                                    สารบัญ)</span></label>
                                            <select name="topic_id" id="topic_id"
                                                class="form-select @error('topic_id') is-invalid @enderror">
                                                <option value="">-- เลือกหัวข้อ --</option>
                                                @forelse ($topics as $topic)
                                                    <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                                @empty
                                                @endforelse
                                            </select>

                                            @error('topic_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="name">ชื่อไฟล์ <span class="text-red text-sm">(เช่น : ปกหน้า,
                                                    ปกหลัง)</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="ชื่อไฟล์" />

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" id="upload-type">
                                            <label class="d-block">ชนิดการอัพโหลด</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="download"
                                                    id="link" value="link"
                                                    @if (old('download') !== null) @if (old('download') == 'link') checked @endif
                                                @else checked @endif>
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
                                                <input class="form-check-input" type="radio" name="download"
                                                    id="file" value="file"
                                                    @if (old('download') !== null) @if (old('download') == 'file') checked @endif
                                                    @endif>
                                                <label class="form-check-label" for="file">
                                                    อัพโหลดเป็นไฟล์ <i style="font-size: 12px;"
                                                        class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                                        ขนาดไฟล์ใหญ่สุดคือ 25 MB)</i>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <input type="file" name="file_upload" id="file-upload"
                                                    class="form-control rounded-0 @error('file_upload') is-invalid @enderror"
                                                    @if (old('download') !== null) @if (old('download') == 'link') disabled @endif
                                                @else disabled @endif
                                                accept=".pdf, .doc, .docx, .jpeg, .jpg, .png">
                                                @error('file_upload')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button onclick="thisDisabled(this)" class="btn btn-success rounded-0"><i
                                                    class="fas fa-save"></i>
                                                บันทึก</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>ไฟล์ Proceedings {{ $year }}</h1>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ชื่อไฟล์</th>
                                <th style="width: 10%;">ลิงค์</th>
                                <th style="width: 10%;">ไฟล์</th>
                                <th style="width: 10%;" class="text-right">แก้ไข</th>
                                <th style="width: 10%;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($i_topic as $distinct_topic)
                                <tr>
                                    @if ($distinct_topic)
                                        <td class="text-start bg-green" colspan="5">
                                            <strong class="text-white">หัวข้อ:
                                                {{ $distinct_topic }}</strong>
                                        </td>
                                    @else
                                        @forelse ($files as $file)
                                            @if ($file->topic == $distinct_topic)
                                                <td class="text-start bg-red" colspan="5">
                                                    <strong class="text-white">หัวข้อ:
                                                        ไม่มีหัวข้อหรือหัวข้อไม่ถูกต้อง</strong>
                                                </td>
                                            @break
                                        @endif
                                    @empty
                                    @endforelse
                                @endif

                            </tr>
                            @forelse ($files as $file)
                                @if ($file->topic == $distinct_topic)
                                    <tr @if (!$distinct_topic) style="background-color: #ffdbdf;" @endif>
                                        <td class="text-start">
                                            <strong>{{ $file->name }}</strong>
                                        </td>
                                        <td>
                                            @if ($file->link)
                                                <strong><a
                                                        href="{{ $file->link }}">{{ $file->link }}</a></strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($file->path)
                                                <strong><a target="_blank"
                                                        href="{{ Storage::url($file->path) }}">{{ $file->name }}.{{ $file->extension }}</a></strong>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right"><a
                                                href="{{ route('backend.proceeding.file.edit', ['year' => $year, 'id' => $file->id]) }}"
                                                class="btn btn-sm text-white btn-warning rounded-0"><i
                                                    class="fa fa-edit"></i>
                                                แก้ไข</a>
                                        </td>
                                        <td><button
                                                onclick="open_modal('{{ $file->name }}', '{{ route('backend.proceeding.file.delete', ['year' => $year, 'id' => $file->id]) }}')"
                                                class="btn btn-sm btn-danger rounded-0"><i
                                                    class="fas fa-trash-alt"></i>
                                                ลบ</button></td>
                                        </td>
                                    </tr>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">ไม่มีหัวข้อ</td>
                                </tr>
                            @endforelse
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
