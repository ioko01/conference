@extends('backend.layouts.master_backend')

@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('backend.download.store') }}"
                    class="mb-3">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="name">เพิ่มหัวข้อดาวน์โหลดไฟล์ <i style="font-size: 12px;" class="text-red">(เช่น
                                ดาวน์โหลดเทมเพลตงานประชุมวิชาการ)</i></label>
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
                                checked>
                            <label class="form-check-label" for="link">
                                อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น
                                    https://www.youtube.com)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="link_upload" id="link-upload" class="form-control rounded-0">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="download" id="file" value="file">
                            <label class="form-check-label" for="file">
                                อัพโหลดเป็นไฟล์ <i style="font-size: 12px;"
                                    class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก ขนาดไฟล์ใหญ่สุดคือ 10 MB)</i>
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="file_upload" id="file-upload" class="form-control rounded-0"
                                disabled>
                        </div>

                        @error('download')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button class="btn btn-success rounded-0">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="card-header">
                <h1>หัวข้อการประชุมวิชาการ</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">ตารางหัวข้อการประชุมวิชาการ</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
