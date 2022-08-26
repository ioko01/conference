@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('backend.oral.link.update', $link_oral->id) }}" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="faculty_id">กลุ่มบทความ</label>
                            <select name="faculty_id" id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                                @forelse ($faculties as $faculty)
                                    @if ($loop->first)
                                        <option value="">-- เลือกกลุ่มบทความ --</option>
                                    @endif
                                    <option value="{{ $faculty->id }}" @if ($link_oral->faculty_id == $faculty->id) selected @endif>
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
                        <div class="col-md-4 mb-3">
                            <label for="room">ชื่อห้อง</label>
                            <input value="{{ $link_oral->room }}" type="text" name="room" id="room"
                                class="form-control rounded-0 @error('room') is-invalid @enderror">
                            @error('room')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="link">Link</label>
                            <input value="{{ $link_oral->link }}" type="text" name="link" id="link"
                                class="form-control rounded-0 @error('link') is-invalid @enderror">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="mb-3">
                                <label class="form-check-label" for="file">
                                    QR Code <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                        ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                                </label>

                                <div class="mb-3" style="position: relative">
                                    <label class="label-type-file mb-0 @error('file') is-invalid @enderror"
                                        for="file">{{ $link_oral->name ? $link_oral->name : 'ไม่ได้เลือกไฟล์ใด' }}</label>
                                    <input type="hidden" value="{{ $link_oral->name }}" name="name_file" id="name_file">

                                    <input onchange="get_file_name(this)" type="file" name="file" id="file"
                                        class="form-control d-none rounded-0 @error('file') is-invalid @enderror"
                                        accept=".jpg, .jpeg, .png">

                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-warning text-white rounded-0"><i class="fa fa-edit"></i> แก้ไข</button>
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
                                <th style="width: 10%;">ห้อง</th>
                                <th style="width: auto;">Link</th>
                                <th style="width: 15%;" class="text-center">QR Code</th>
                                <th style="width: 15%;">กลุ่มคณะ</th>
                                <th style="width: 5%;" class="text-right">แก้ไข</th>
                                <th style="width: 5%;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($link_orals as $key => $link_oral)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $link_oral->room }}</td>
                                    <td><a href="{{ $link_oral->link }}" target="_blank"
                                            rel="noopener noreferrer">{{ $link_oral->link }}</a></td>
                                    <td class="text-center">
                                        <button class="btn btn-link"
                                            onclick="open_modal_default('#modal', 'sm', 'QR Code', {{ $link_oral }})"><i
                                                class="fa fa-search-plus"> </i> ดูภาพ</button>
                                    </td>
                                    <td>{{ $link_oral->faculty_name }}</td>
                                    <td class="text-right"><a href="{{ route('backend.oral.link.edit', $link_oral->id) }}"
                                            class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                            แก้ไข</a>
                                    </td>
                                    <td><button
                                            onclick="open_modal('{{ $link_oral->room }}', '{{ route('backend.oral.link.delete', $link_oral->id) }}')"
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
