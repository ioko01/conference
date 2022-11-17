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
                <div class="panel">
                    <div class="body">
                        <div class="input-group">
                            <label for="search">ค้นหาบทความ</label>
                            <input type="text" class="form-control" name="search" id="search"
                                placeholder="">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="list table responsive hover">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 35%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 20%;">สังกัด/หน่วยงาน</th>
                                <th style="width: 10%;">ไฟล์<br />WORD</th>
                                <th style="width: 10%;">ไฟล์<br />PDF</th>
                                <th style="width: 10%;">แบบคำชี้แจงการปรับแก้ไขบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($data as $key => $value)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-start">
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            @if ($value->present_id == 1)
                                                Oral
                                            @else
                                                Poster
                                            @endif
                                        </strong>
                                        <br />
                                        <strong>
                                            {{ $value->topic_th }}@if ($value->user_id == auth()->user()->id)
                                                <i class="text-bluesky"> (ฉัน)</i>
                                            @endif
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px"
                                            class="text-green">{{ str_replace('|', ', ', $value->presenter) }}</strong>
                                    </td>
                                    <td>
                                        {{ $value->institution }}
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
