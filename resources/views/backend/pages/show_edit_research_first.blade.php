@extends('backend.layouts.master_backend')

@section('content')
    <!-- Content -->
    <div class="card">
        <div class="card-content">
            <div class="card-header bg-green rounded-0">
                <strong>
                    <i class="nav-icon fas fa-book-open"></i>
                    บทความฉบับแก้ไขครั้งที่ 1
                </strong>
            </div>

            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 35%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 10%;">WORD</th>
                                <th style="width: 10%;">PDF</th>
                                <th style="width: 10%;">แบบคำชี้แจงการปรับแก้ไขบทความ</th>
                                <th style="width: 10%;">VIDEO</th>
                                <th style="width: 10%;">POSTER</th>
                                <th style="width: 10%;">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($data as $key => $value)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-start">
                                        <strong style="font-size: 12px" class="text-warning">
                                            รหัสบทความ: {{ $value->topic_id }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            รูปแบบ: {{ $value->present }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-primary">สังกัด /
                                            หน่วยงาน : {{ $value->institution }}</strong>
                                        <br />
                                        <strong>
                                            {{ $value->topic_th }}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-green">ผู้นำเสนอ :
                                            {{ str_replace('|', ', ', $value->presenter) }}</strong>
                                    </td>
                                    <td>
                                        @if (empty($value->word))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->word_path) }}">
                                                WORD-1
                                                <span style="font-size: 10px;" class="text-green d-block">อัพโหลด
                                                    {{ thaiDateFormat($value->word_created_at, true, true) }}</span>
                                                <span style="font-size: 10px;" class="text-green d-block">แก้ไข
                                                    {{ thaiDateFormat($value->word_updated_at, true, true) }}</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->pdf))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->pdf_path) }}">PDF-1
                                                <span style="font-size: 10px;" class="text-green d-block">อัพโหลด
                                                    {{ thaiDateFormat($value->pdf_created_at, true, true) }}</span>
                                                <span style="font-size: 10px;" class="text-green d-block">แก้ไข
                                                    {{ thaiDateFormat($value->pdf_updated_at, true, true) }}</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->statement))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->statement_path) }}">STM-1
                                                <span style="font-size: 10px;" class="text-green d-block">อัพโหลด
                                                    {{ thaiDateFormat($value->statement_created_at, true, true) }}</span>
                                                <span style="font-size: 10px;" class="text-green d-block">แก้ไข
                                                    {{ thaiDateFormat($value->statement_updated_at, true, true) }}</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->video))
                                            -
                                        @else
                                            <a target="_blank" href="{{ $value->video }}">VDO
                                                <span style="font-size: 10px;" class="text-green d-block">อัพโหลด
                                                    {{ thaiDateFormat($value->video_created_at, true, true) }}</span>
                                                <span style="font-size: 10px;" class="text-green d-block">แก้ไข
                                                    {{ thaiDateFormat($value->video_updated_at, true, true) }}</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->poster))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->poster_path) }}">POSTER
                                                <span style="font-size: 10px;" class="text-green d-block">อัพโหลด
                                                    {{ thaiDateFormat($value->video_created_at, true, true) }}</span>
                                                <span style="font-size: 10px;" class="text-green d-block">แก้ไข
                                                    {{ thaiDateFormat($value->video_updated_at, true, true) }}</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success rounded-0 text-white"
                                            onclick="open_modal(this, 'detail')">
                                            รายละเอียด
                                        </button>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">ไม่มีบทความ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>
@endsection
