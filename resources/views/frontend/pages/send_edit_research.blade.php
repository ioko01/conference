@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h2 class="text-center">ส่งบทความฉบับแก้ไข ครั้งที่ 1</h2>
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
                        <th style="width: 15%;">ไฟล์แก้ไขจากผู้ทรงฯ</th>
                        <th style="width: 15%;">ไฟล์ WORD ฉบับแก้ไขครั้งที่ 1</th>
                        <th style="width: 15%;">ไฟล์ PDF ฉบับแก้ไขครั้งที่ 1</th>
                        <th style="width: 15%;">แบบคำชี้แจงการปรับแก้ไขบทความครั้งที่ 1</th>
                        <th style="width: 10%;">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $value)
                        <tr class="text-center">
                            <td>{{ $value->id }}</td>
                            <td style="vertical-align: middle;">{{ $value->topic_th }}
                                <br /><span
                                    class="name-research text-small text-green">{{ str_replace('|', ', ', $value->presenter) }}</span>
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($value->status_id >= 8)
                                    @forelse ($comments as $key => $comment)
                                        <div class="text-start">
                                            <a target="_blank" href="{{ Storage::url($comment->comment_path) }}">
                                                {{ ++$key }}. <i
                                                    style="font-size: 10px;">{{ $comment->comment_name }}</i>
                                            </a>
                                        </div>
                                    @empty
                                        <strong class="text-warning">(รอบทความแก้ไขจากผู้ทรงคุณวุฒิ)</strong>
                                    @endforelse
                                @else
                                    -
                                @endif
                            </td>
                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_word_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_word_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_word_ext }}">
                                    <p class="mb-0">{{ $value->edit_word_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_word_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                @endif
                                @if ($value->status_research_edit == 1)
                                    @if (endDate('end_research_edit')->day >= 0)
                                        @if ($value->status_id >= 8)
                                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                onclick="open_modal(this, 'word'@if (isset($value->edit_pdf_path)) , 'PUT' @endif)">
                                                @if (isset($value->edit_word_path))
                                                    แก้ไขไฟล์ WORD ฉบับแก้ไข
                                                @else
                                                    อัพโหลดไฟล์ WORD ฉบับแก้ไข
                                                @endif
                                            </button>
                                            <input type="hidden" value="{{ $value->topic_id }}">
                                        @else
                                            <strong class="text-red">ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1</strong>
                                    @endif
                                @else
                                    <strong class="text-red">ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1</strong>
                                @endif
                            </td>

                            @error('word_upload')
                                <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror


                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_pdf_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_pdf_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_pdf_ext }}">
                                    <p class="mb-0">{{ $value->edit_pdf_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_pdf_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                @endif
                                @if ($value->status_research_edit === 1)
                                    @if (endDate('end_research_edit')->day >= 0)
                                        @if ($value->status_id >= 8)
                                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                onclick="open_modal(this, 'pdf'@if (isset($value->edit_pdf_path)) , 'PUT' @endif)">
                                                @if (isset($value->edit_pdf_path))
                                                    แก้ไขไฟล์ PDF ฉบับแก้ไข
                                                @else
                                                    อัพโหลดไฟล์ PDF ฉบับแก้ไข
                                                @endif
                                            </button>
                                            <input type="hidden" value="{{ $value->topic_id }}">
                                        @else
                                            <strong class="text-red">ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1</strong>
                                    @endif
                                @else
                                    <strong class="text-red">ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1</strong>
                                @endif
                            </td>

                            @error('pdf_upload')
                                <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror

                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_stm_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_stm_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_stm_path }}">
                                    <p class="mb-0">{{ $value->edit_stm_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_stm_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_stm_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                @endif
                                @if ($value->status_research_edit === 1)
                                    @if (endDate('end_research_edit')->day >= 0)
                                        @if ($value->status_id >= 8)
                                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                onclick="open_modal(this, 'stm'@if (isset($value->edit_stm_path)) , 'PUT' @endif)">
                                                @if (isset($value->edit_stm_path))
                                                    แก้ไขแบบคำชี้แจง
                                                @else
                                                    อัพโหลดแบบคำชี้แจง
                                                @endif
                                            </button>
                                            <input type="hidden" value="{{ $value->topic_id }}">
                                        @else
                                            <strong class="text-red">ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1</strong>
                                    @endif
                                @else
                                    <strong class="text-red">ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1</strong>
                                @endif

                            </td>
                            @error('stm_upload')
                                <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror

                            <td style="vertical-align: middle;">
                                <button type="button" class="btn btn-green rounded-0 text-white"
                                    onclick="open_modal(this, 'detail')">
                                    รายละเอียด
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" style="vertical-align: middle;">ไม่มีบทความของท่าน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>

@endsection
