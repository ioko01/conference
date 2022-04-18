@extends('backend.layouts.master_backend')

@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <form method="POST" action="#" class="mb-3">
                @csrf
                <div class="col-12 mb-3">
                    <label for="topic">เพิ่มหัวข้อดาวน์โหลดไฟล์ <i style="font-size: 12px;" class="text-red">(เช่น ดาวน์โหลดเทมเพลตงานประชุมวิชาการ)</i></label>
                    <input value="{{ old('topic') }}" type="text" name="topic" id="topic"
                        class="form-control rounded-0 @error('topic') is-invalid @enderror">
                    @error('topic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="d-block">ชนิดการอัพโหลด</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="download" id="link" value="link" checked>
                        <label class="form-check-label" for="link">
                            อัพโหลดเป็นลิงค์ <i style="font-size: 12px;" class="text-red">(เช่น www.youtube.com)</i>
                        </label>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="link-upload" id="link-upload" class="form-control">
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="download" id="file" value="file">
                        <label class="form-check-label" for="file">
                            อัพโหลดเป็นไฟล์ <i style="font-size: 12px;" class="text-red">(แนะนำเฉพาะไฟล์ที่มีขนาดเล็ก)</i>
                        </label>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="file-upload" id="file-upload" class="form-control">
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