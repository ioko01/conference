@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
<!-- Content -->
<div class="bg-white text-blue p-5 my-5">

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
                    <th style="width: 25%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 15%;">ไฟล์ WORD ฉบับแก้ไขครั้งที่ 2</th>
                    <th style="width: 15%;">ไฟล์ PDF ฉบับแก้ไขครั้งที่ 2</th>
                    <th style="width: 15%;">แบบคำชี้แจงการปรับแก้ไขบทความครั้งที่ 2</th>
                    <th style="width: 10%;">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $value)
                <tr class="text-center">
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->topic_th }}
                        <br /><span class="name-research text-small text-green">{{ $value->presenter }}</span>
                    </td>
                    @if(isset($value->edit_word_path) || isset($value->edit_pdf_path) || isset($value->edit_stm_path))
                    <td>
                        @if (isset($value->edit_word_path_two))
                        <img width="40" src="{{ asset("images/$value->edit_word_ext_two.png", env('REDIRECT_HTTPS'))
                        }}"
                        alt="{{ $value->edit_word_ext_two }}">
                        <p class="mb-0">{{ $value->edit_word_name_two }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                            {{ date('d-m-Y H:i:s', strtotime($value->edit_word_update_two)) }}</i>
                        <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->edit_word_path_two) }}">
                            ดูตัวอย่าง
                        </a>
                        @endif
                        <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                            onclick="open_modal(this, 'word_2'@if (isset($value->edit_word_path_two)), 'PUT' @endif)">
                            @if (isset($value->edit_word_path_two))
                            แก้ไขไฟล์ WORD ฉบับแก้ไข
                            @else
                            อัพโหลดไฟล์ WORD ฉบับแก้ไข
                            @endif
                        </button>
                        <input type="hidden" value="{{ $value->topic_id }}">

                        @error('word_upload')
                        <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                        @enderror

                    </td>
                    <td>
                        @if (isset($value->edit_pdf_path_two))
                        <img width="40" src="{{ asset("images/$value->edit_pdf_ext_two.png", env('REDIRECT_HTTPS')) }}"
                        alt="{{ $value->edit_pdf_ext_two }}">
                        <p class="mb-0">{{ $value->edit_pdf_name_two }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                            {{ date('d-m-Y H:i:s', strtotime($value->edit_pdf_update_two)) }}</i>
                        <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->edit_pdf_path_two) }}">
                            ดูตัวอย่าง
                        </a>
                        @endif
                        <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                            onclick="open_modal(this, 'pdf_2'@if (isset($value->edit_pdf_path_two)), 'PUT' @endif)">
                            @if (isset($value->edit_pdf_path_two))
                            แก้ไขไฟล์ PDF ฉบับแก้ไข
                            @else
                            อัพโหลดไฟล์ PDF ฉบับแก้ไข
                            @endif
                        </button>
                        <input type="hidden" value="{{ $value->topic_id }}">


                        @error('pdf_upload')
                        <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                        @enderror
                    </td>
                    <td>
                        @if (isset($value->edit_stm_path_two))
                        <img width="40" src="{{ asset("images/$value->edit_stm_ext_two.png", env('REDIRECT_HTTPS')) }}"
                        alt="{{ $value->edit_stm_path_two }}">
                        <p class="mb-0">{{ $value->edit_stm_name_two }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                            {{ date('d-m-Y H:i:s', strtotime($value->edit_stm_update_two)) }}</i>
                        <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->edit_stm_path_two) }}">
                            ดูตัวอย่าง
                        </a>
                        @endif
                        <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                            onclick="open_modal(this, 'stm_2'@if (isset($value->edit_stm_path_two)), 'PUT' @endif)">
                            @if (isset($value->edit_stm_path_two))
                            แก้ไขแบบคำชี้แจงการปรับแก้ไขบทความ
                            @else
                            อัพโหลดแบบคำชี้แจงการปรับแก้ไขบทความ
                            @endif
                        </button>
                        <input type="hidden" value="{{ $value->topic_id }}">


                        @error('stm_upload')
                        <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                        @enderror
                    </td>

                    @else
                    <td colspan="3">
                        <strong class="text-red">ไม่สามารถอัพโหลดแก้ไขครั้งที่ 2 ได้</strong>
                    </td>
                    @endif
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