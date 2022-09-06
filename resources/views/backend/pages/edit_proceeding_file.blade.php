@extends('backend.layouts.master_backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-green p-3">
                <strong>PROCEEDING {{ $year }}</strong>
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
                                                <span><i class="fas fa-plus"></i></span> เพิ่มหัวข้อ Proceeding</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page"
                                                href="{{ route('backend.proceeding.file.index', $year) }}">
                                                <span><i class="fas fa-file-upload"></i></span> อัพโหลดไฟล์ Proceeding
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark"
                                                href="{{ route('backend.proceeding.research.index', $year) }}">
                                                <span><i class="fas fa-book"></i></span> อัพโหลดบทความ Proceeding</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form
                                action="{{ route('backend.proceeding.file.update', ['year' => $year, 'id' => $_file->id]) }}"
                                enctype="multipart/form-data" method="POST" class="col-md-12">
                                @csrf
                                @method('PUT')
                                <div class="border border-top-0 p-3">
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-6">
                                            <label for="topic_id">หัวข้อ <span class="text-red text-sm">(เช่น : หน้าปก,
                                                    ส่วนหน้า,
                                                    สารบัญ)</span></label>
                                            <select name="topic_id" id="topic_id" class="form-select">
                                                <option value="">-- เลือกหัวข้อ --</option>
                                                @forelse ($topics as $topic)
                                                    <option value="{{ $topic->id }}"
                                                        @if ($_file->topic_id == $topic->id) selected @endif>
                                                        {{ $topic->topic }}</option>
                                                @empty
                                                @endforelse
                                            </select>

                                            @error('topic')
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
                                            <input value="{{ $_file->name }}" type="text" name="name" id="name"
                                                class="form-control" placeholder="ชื่อไฟล์" />

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="upload-type">
                                        <label class="d-block">ชนิดการอัพโหลด</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="download" id="link"
                                                value="link"
                                                @if (old('download') !== null) @if (old('download') == 'link') checked @endif
                                            @elseif(isset($_file->link)) checked @endif>
                                            <label class="form-check-label" for="link">
                                                อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                                    https://www.youtube.com)</i>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <input value="{{ $_file->link }}" type="text" name="link_upload"
                                                id="link-upload"
                                                class="form-control rounded-0 @error('link_upload') is-invalid @enderror"
                                                @if (old('download') !== null) @if (old('download') == 'file') disabled @endif
                                            @elseif(isset($_file->path)) disabled @endif>
                                            @error('link_upload')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="download" id="file"
                                                value="file"
                                                @if (old('download') !== null) @if (old('download') == 'file') checked @endif
                                            @elseif(isset($_file->path)) checked @endif>
                                            <label class="form-check-label" for="file">
                                                อัพโหลดเป็นไฟล์ <i style="font-size: 12px;"
                                                    class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                                    ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                                            </label>
                                        </div>
                                        <div class="mb-3" style="position: relative">
                                            <label class="label-type-file mb-0 @error('file_upload') is-invalid @enderror"
                                                @if (old('download') !== null) @if (old('download') == 'link') style="background-color:#e9ecef;cursor:default" @endif
                                            @elseif($_file->link)
                                                style="background-color:#e9ecef;cursor:default" @endif
                                                for="file-upload">{{ $_file->path ? $_file->name . '.' . $_file->extension : 'ไม่ได้เลือกไฟล์ใด' }}</label>
                                            <input type="hidden" value="{{ $_file->name }}.{{ $_file->extension }}"
                                                name="name_file" id="name_file">

                                            <input onchange="get_file_name(this)" type="file" name="file_upload"
                                                id="file-upload"
                                                class="form-control d-none rounded-0 @error('file_upload') is-invalid @enderror"
                                                @if (old('download') !== null) @if (old('download') == 'link') disabled @endif
                                            @elseif(!isset($_file->path)) disabled @endif>

                                            @error('file_upload')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button onclick="thisDisabled(this)" class="btn btn-warning text-white rounded-0"><i
                                                    class="fas fa-edit"></i>
                                                แก้ไข</button>
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
                <h1>ไฟล์ Proceeding {{ $year }}</h1>
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
                                        <td class="text-center">
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
                                                onclick="open_modal('{{ $file->topic }}', '{{ route('backend.proceeding.file.delete', ['year' => $year, 'id' => $file->id]) }}')"
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
