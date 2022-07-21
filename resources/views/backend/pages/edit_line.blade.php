@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.line.store') }}" class="mb-3">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="conference_name">ชื่อหัวข้อ <i style="font-size: 12px;" class="text-red">(ตัวอย่าง:
                                งานประชุมวิชาการระดับชาติ ราชภัฏเลยวิชาการ มหาวิทยาลัยราชภัฏเลย ครั้งที่ 1)</i></label>
                        <select name="conference_name" id="conference_name"
                            class="form-select @error('conference_name') is-invalid @enderror">
                            @forelse ($conferences as $conference)
                                <option @if ($conference->id) value="{{ $conference->id }}" @endif
                                    @if (old('conference_name')) @if (old('conference_name') == $conference->id) selected @endif
                                    @endif>
                                    {{ $conference->name }}</option>
                                @empty
                                    <option value>ไม่มีการประชุมที่เปิดใช้งาน</option>
                                @endforelse
                            </select>
                            @error('conference_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check-label" for="link">
                                    ลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                        https://www.youtube.com)</i>
                                </label>
                                <input type="text" name="link" id="link"
                                    class="form-control rounded-0 @error('link') is-invalid @enderror">
                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-check-label" for="file">
                                    อัพโหลดไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                        ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                                </label>
                                <input type="file" name="file" id="file"
                                    class="form-control rounded-0 @error('file') is-invalid @enderror"
                                    accept=".jpg, .jpeg, .png">
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                    <h1>Line Openchat</h1>
                </div>
                <div class="card-body text-xs">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>หัวข้อ</th>
                                    <th>Link Open Chat</th>
                                    <th>ไฟล์อัพโหลด</th>
                                    <th class="text-right">แก้ไข</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lines as $key => $line)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $line->conference_name ? $line->conference_name : '-' }}</td>
                                        <td>
                                            @if ($line->line_link)
                                                <a target="_blank" href="{{ $line->line_link }}">{{ $line->line_link }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($line->line_name)
                                                <a target="_blank"
                                                    href="{{ Storage::url($line->line_path) }}">{{ $line->line_name }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-right"><a href="{{ route('backend.line.edit', $line->id) }}"
                                                class="btn btn-sm text-white btn-warning rounded-0"><i class="fa fa-edit"></i>
                                                แก้ไข</a>
                                        </td>
                                        <td><button class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash-alt"></i>
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
