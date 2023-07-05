@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">

        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-1x fa-book"></i> ส่งบทความแก้ไขหลังนำเสนอ</h4>
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
                        <th style="width: 15%;">ไฟล์ WORD แก้ไขหลังนำเสนอ</th>
                        <th style="width: 15%;">ไฟล์ PDF แก้ไขหลังนำเสนอ</th>
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
                                <strong>{!! $value->topic_th !!}</strong>
                                <br />
                                <strong><span class="name-research text-small text-green">ผู้นำเสนอ :
                                        {{ str_replace('!!', ' ', str_replace('|', ', ', $value->presenter)) }}</span></strong>
                                <br />
                                <strong style="font-size: 12px" class="text-bluesky">
                                    รูปแบบบทความ : {{ $value->present }}
                                </strong>
                            </td>





                            <input type="hidden" id="err_word"
                                @error('word_upload')
                                value="{!! $message !!}"
                            @enderror>

                            <input type="hidden" id="err_pdf"
                                @error('pdf_upload')
                                value="{!! $message !!}"
                            @enderror>


                            @if ($value->research_passed_1 == 2)
                                @if (isset($value->edit_word_path) && isset($value->edit_pdf_path) && isset($value->edit_stm_path))
                                    @if ($value->status_payment)
                                        @if (isset($value->edit_word_path_two) && isset($value->edit_pdf_path_two))
                                            <td colspan="2">
                                                <table class="w-100">
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-0" style="vertical-align: middle;">
                                                                <img width="40"
                                                                    src="{{ asset("images/$value->edit_word_ext_two.webp", env('REDIRECT_HTTPS')) }}"
                                                                    alt="{{ $value->edit_word_ext_two }}">
                                                                <p class="mb-0">{{ $value->edit_word_name_two }}</p>
                                                                <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                                                    {{ thaiDateFormat($value->edit_word_update_two, true) }}</i>
                                                                <a target="_blank"
                                                                    class="btn btn-green text-white rounded-0 w-100 my-1"
                                                                    href="{{ Storage::url($value->edit_word_path_two) }}">
                                                                    ดูตัวอย่าง
                                                                </a>
                                                            </td>
                                                            <td class="border-0" style="vertical-align: middle;">
                                                                <img width="40"
                                                                    src="{{ asset("images/$value->edit_pdf_ext_two.webp", env('REDIRECT_HTTPS')) }}"
                                                                    alt="{{ $value->edit_pdf_ext_two }}">
                                                                <p class="mb-0">{{ $value->edit_pdf_name_two }}</p>
                                                                <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                                                    {{ thaiDateFormat($value->edit_pdf_update_two, true) }}</i>
                                                                <a target="_blank"
                                                                    class="btn btn-green text-white rounded-0 w-100 my-1"
                                                                    href="{{ Storage::url($value->edit_pdf_path_two) }}">
                                                                    ดูตัวอย่าง
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-0" colspan="2">
                                                                @if ($value->status_research_edit_two === 1)
                                                                    @if (endDate('end_research_edit_two')->day >= 0)
                                                                        <button type="button"
                                                                            class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                                            onclick="open_modal(this, 'edit_research_second'@if (isset($value->edit_word_path_two) && isset($value->edit_pdf_path_two)) , 'PUT' @endif)">
                                                                            @if (isset($value->edit_word_path_two) && isset($value->edit_pdf_path_two))
                                                                                <i class="nav-icon fas fa-upload"></i>
                                                                                แก้ไขไฟล์แก้ไขหลังนำเสนอ
                                                                            @else
                                                                                <i class="nav-icon fas fa-upload"></i>
                                                                                อัพโหลดไฟล์แก้ไขหลังนำเสนอ
                                                                            @endif
                                                                        </button>
                                                                        <input type="hidden"
                                                                            value="{{ $value->topic_id }}">
                                                                    @else
                                                                        <h1 class="text-danger text-center">
                                                                            <strong style="font-size: calc(.1vw + 10px);">
                                                                                สิ้นสุดการรับบทความแก้ไขหลังนำเสนอ
                                                                            </strong>
                                                                        </h1>
                                                                    @endif
                                                                @else
                                                                    <h1 class="text-danger text-center">
                                                                        <strong style="font-size: calc(.1vw + 10px);">
                                                                            ยังไม่เปิดให้อัพโหลดไฟล์แก้ไขหลังนำเสนอ</strong>
                                                                    </h1>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </td>
                                        @else
                                            <td colspan="2" style="vertical-align: middle;">
                                                <table class="w-100">
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-0" colspan="2">
                                                                @if ($value->status_research_edit_two === 1)
                                                                    @if (endDate('end_research_edit_two')->day >= 0)
                                                                        <button type="button"
                                                                            class="btn btn-green text-white rounded-0 w-100 my-1"
                                                                            onclick="open_modal(this, 'edit_research_second')">
                                                                            <i class="nav-icon fas fa-upload"></i>
                                                                            อัพโหลดไฟล์แก้ไขหลังนำเสนอ
                                                                        </button>
                                                                        <input type="hidden"
                                                                            value="{{ $value->topic_id }}">
                                                                    @else
                                                                        <h1 class="text-danger text-center">
                                                                            <strong style="font-size: calc(.1vw + 10px);">
                                                                                สิ้นสุดการรับบทความแก้ไขหลังนำเสนอ
                                                                            </strong>
                                                                        </h1>
                                                                    @endif
                                                                @else
                                                                    <h1 class="text-danger text-center">
                                                                        <strong style="font-size: calc(.1vw + 10px);">
                                                                            ยังไม่เปิดให้อัพโหลดไฟล์แก้ไขหลังนำเสนอ</strong>
                                                                    </h1>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        @endif
                                    @else
                                        <td colspan="2">
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    ยังไม่เปิดรับบทความแก้ไขหลังนำเสนอ
                                                </strong>
                                            </h1>

                                        </td>
                                    @endif
                                @else
                                    <td colspan="2">
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ไม่สามารถอัพโหลดแก้ไขหลังนำเสนอ ได้
                                            </strong>
                                        </h1>

                                    </td>
                                @endif
                            @elseif($value->research_passed_1 == 0)
                                <td colspan="2">
                                    <h1 class="text-warning text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            บทความนี้อยู่ระหว่างการพิจารณาบทความครั้งที่ 1
                                        </strong>
                                    </h1>
                                </td>
                            @elseif($value->research_passed_1 == 1)
                                <td colspan="2">
                                    <h1 class="text-green text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            ผ่านการพิจารณาการปรับแก้ไขแล้ว
                                        </strong>
                                    </h1>
                                </td>
                            @endif

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
                            <td colspan="5">ไม่มีบทความของท่าน</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
