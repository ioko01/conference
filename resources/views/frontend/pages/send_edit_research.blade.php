@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-1x fa-book"></i> ส่งบทความฉบับแก้ไข ครั้งที่ 1</h4>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>


        <div class="col-md-12 mx-auto table-responsive">
            <table class="dataTable table w-100">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;" class="text-start">รายละเอียดบทความ</th>
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
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start">
                                <strong style="font-size: 12px" class="text-warning">
                                    รหัสบทความ : {{ $value->topic_id }}
                                </strong>
                                <br />
                                <strong style="font-size: 12px" class="text-bluesky">
                                    รูปแบบ : {{ $value->present }}
                                </strong>
                                <br />
                                <strong>{{ $value->topic_th }}</strong>
                                <br />
                                <strong><span class="name-research text-small text-green">ผู้นำเสนอ :
                                        {{ str_replace('|', ', ', $value->presenter) }}</span></strong>
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($value->status_id >= 8)
                                    @forelse ($comments as $key => $comment)
                                        @if ($comment->comment_topic_id == $value->topic_id)
                                            <div class="text-start">
                                                <a class="text-green" target="_blank"
                                                    href="{{ Storage::url($comment->comment_path) }}">
                                                    &bull; <i style="font-size: 10px;">{{ $comment->comment_name }}</i>
                                                </a>
                                            </div>
                                            <div style="border-bottom: 1px dotted #ccc;" class="my-2"></div>
                                        @endif
                                    @empty
                                        <h1 class="text-warning text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                (รอบทความแก้ไขจากผู้ทรงคุณวุฒิ)
                                            </strong>
                                        </h1>
                                    @endforelse
                                @else
                                    -
                                @endif
                            </td>
                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_word_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_word_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_word_ext }}">
                                    <p class="mb-0">{{ $value->edit_word_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_word_path) }}">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1
                                            </strong>
                                        </h1>
                                    @endif
                                @elseif($value->status_research_edit_two === 1)
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            หมดเวลาอัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1 แล้ว
                                        </strong>
                                    </h1>
                                @else
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1
                                        </strong>
                                    </h1>
                                @endif
                            </td>

                            @error('word_upload')
                                <h1 class="text-danger text-center">
                                    <strong style="font-size: calc(.1vw + 10px);">
                                        ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง
                                    </strong>
                                </h1>
                            @enderror


                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_pdf_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_pdf_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_pdf_ext }}">
                                    <p class="mb-0">{{ $value->edit_pdf_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_pdf_path) }}">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1
                                            </strong>
                                        </h1>
                                    @endif
                                @elseif($value->status_research_edit_two === 1)
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            หมดเวลาอัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1 แล้ว
                                        </strong>
                                    </h1>
                                @else
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1
                                        </strong>
                                    </h1>
                                @endif
                            </td>

                            @error('pdf_upload')
                                <h1 class="text-danger text-center">
                                    <strong style="font-size: calc(.1vw + 10px);">
                                        ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง
                                    </strong>
                                </h1>
                            @enderror

                            <td style="vertical-align: middle;">
                                @if (isset($value->edit_stm_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->edit_stm_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->edit_stm_path }}">
                                    <p class="mb-0">{{ $value->edit_stm_name }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->edit_stm_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->edit_stm_path) }}">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    ต้องมีสถานะส่งบทความให้นักวิจัยแก้ไขแล้ว
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                สิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 1
                                            </strong>
                                        </h1>
                                    @endif
                                @elseif($value->status_research_edit_two === 1)
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            หมดเวลาอัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1 แล้ว
                                        </strong>
                                    </h1>
                                @else
                                    <h1 class="text-danger text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ยังไม่เปิดให้อัพโหลดไฟล์ฉบับแก้ไขครั้งที่ 1
                                        </strong>
                                    </h1>
                                @endif

                            </td>
                            @error('stm_upload')
                                <h1 class="text-danger text-center">
                                    <strong style="font-size: calc(.1vw + 10px);">
                                        ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง
                                    </strong>
                                </h1>
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
