@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-header bg-green rounded-0">
                <strong>
                    <i class="fas fa-link"></i> 
                    ลิงค์นำเสนอ Oral
                </strong>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.oral.link.store') }}"
                    class="mb-3">
                    @csrf
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
                        <div class="col-md-4 mb-3">
                            <label for="room">ชื่อห้อง</label>
                            <input value="{{ old('room') }}" type="text" name="room" id="room"
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
                            <input value="{{ old('link') }}" type="text" name="link" id="link"
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
                            <label for="file">QR Code</label>
                            <input accept=".jpg, .jpeg, .png" type="file" name="file" id="file"
                                class="form-control rounded-0 @error('file') is-invalid @enderror">
                            @error('file')
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
