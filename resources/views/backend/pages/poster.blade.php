@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.download.store') }}"
                    class="mb-3">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="poster_id">รหัสการนำเสนอ</label>
                        <input value="{{ old('poster_id') }}" type="text" name="poster_id" id="poster_id"
                            class="form-control rounded-0 @error('poster_id') is-invalid @enderror">
                        @error('poster_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="topic">ชื่อบทความ</label>
                        <input value="{{ old('topic') }}" type="text" name="topic" id="topic"
                            class="form-control rounded-0 @error('topic') is-invalid @enderror">
                        @error('topic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="link">Link คลิปวิดีโอ</label>
                        <input value="{{ old('link') }}" type="text" name="link" id="link"
                            class="form-control rounded-0 @error('link') is-invalid @enderror">
                        @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-check-label" for="file">
                            อัพโหลดเป็นไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก
                                ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                        </label>
                        <input type="file" name="file_upload" id="file-upload"
                            class="form-control rounded-0 @error('file_upload') is-invalid @enderror"
                        @if (old('download') !== null) @if (old('download') == 'link') disabled @endif @else
                            disabled @endif>
                        @error('file_upload')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal"></div>
@endsection
