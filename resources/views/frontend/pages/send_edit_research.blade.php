@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                เพิ่มบทความสำเร็จ
            </div>
        @endif

        <div class="inner-content-header">
            <h2 class="text-center">รายชื่อรายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>

        <div>
            <h1>รายชื่อรายชื่อบทความ</h1>
        </div>
        <div class="panel">
            <div class="body">
                <div class="input-group">
                    <label for="search">ค้นหาบทความ</label>
                    <input type="text" class="form-control" name="search" id="search"
                        placeholder="ค้นหาผ่านลำดับ, รหัสบทความ, บทความ/ผู้วิจัย, สังกัด/กลุ่มคณะ, สถานะ, รูปแบบ">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="list table responsive hover">
                <thead>
                    <tr class="text-center pagination-header">
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">ชื่อบทความ/ผู้วิจัย</th>
                        <th style="width: 10%;">ไฟล์ WORD ฉบับแก้ไข</th>
                        <th style="width: 10%;">ไฟล์ PDF ฉบับแก้ไข</th>
                        <th style="width: 5%;">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $value)
                        <tr class="text-center">
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->topic_th }}
                                <br /><span class="name-research text-small text-green">{{ $value->presenter }}</span>
                            </td>
                            <td>
                                @if (isset($value->edit_word_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_word_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_word_ext }}">
                                    <p class="mb-0">{{ $value->edit_word_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ date('d-m-Y H:i:s', strtotime($value->edit_word_update)) }}</i>
                                    <a class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_word_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                @endif
                                @if ($value->status_id == 9)
                                    <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                        onclick="open_modal(this, 'word'@if (isset($value->edit_pdf_path)), 'PUT' @endif)">
                                        @if (isset($value->edit_word_path))
                                            แก้ไขไฟล์ WORD ฉบับแก้ไข
                                        @else
                                            อัพโหลดไฟล์ WORD ฉบับแก้ไข
                                        @endif
                                    </button>
                                    <input type="hidden" value="{{ $value->topic_id }}">
                                @else
                                    <strong class="text-red">ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไข<br/>กรุณารอบทความแก้ไขจากผู้ทรงฯ</strong>
                                @endif

                                @error('word_upload')
                                    <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                                @enderror

                            </td>
                            <td>
                                @if (isset($value->edit_pdf_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_pdf_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_pdf_ext }}">
                                    <p class="mb-0">{{ $value->edit_pdf_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ date('d-m-Y H:i:s', strtotime($value->edit_pdf_update)) }}</i>
                                    <a class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_pdf_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                @endif
                                @if ($value->status_id == 9)
                                    <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                        onclick="open_modal(this, 'pdf'@if (isset($value->edit_pdf_path)), 'PUT' @endif)">
                                        @if (isset($value->edit_pdf_path))
                                            แก้ไขไฟล์ PDF ฉบับแก้ไข
                                        @else
                                            อัพโหลดไฟล์ PDF ฉบับแก้ไข
                                        @endif
                                    </button>
                                    <input type="hidden" value="{{ $value->topic_id }}">
                                @else
                                    <strong class="text-red">ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไข<br/>กรุณารอบทความแก้ไขจากผู้ทรงฯ</strong>
                                @endif


                                @error('pdf_upload')
                                    <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                                @enderror
                            </td>
                            <td>
                                <button type="button" class="btn btn-green rounded-0 text-white"
                                    onclick="open_modal(this, 'detail')">
                                    รายละเอียด
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8">ไม่มีบทความของท่าน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>

@endsection
