@extends('backend.layouts.master_backend')

@section('content')
    <!-- Content -->
    <div class="card">
        <div class="card-content">
            <div class="card-header d-flex align-items-center justify-content-between w-100">
                <h1>จัดการรายชื่อรายชื่อบทความ</h1>
                <div class="ms-auto">
                    <a href="{{ route('researchs.export') }}" class="btn btn-info rounded-0"><i
                            class="fas fa-file-export"></i>
                        Export to
                        Excel</a>
                </div>
            </div>
            <div class="panel">
                <div class="body">
                    <div class="input-group">
                        <label for="search">ค้นหาบทความ</label>
                        <input type="text" class="form-control" name="search" id="search"
                            placeholder="ค้นหาผ่านลำดับ, ชื่อบทความ/ผู้นำเสนอผลงาน, สังกัด/หน่วยงาน">
                    </div>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="table-responsive">
                    <table class="list table responsive hover">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 50%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 20%;">สังกัด/หน่วยงาน</th>
                                <th style="width: 5%;">ไฟล์<br />WORD</th>
                                <th style="width: 5%;">ไฟล์<br />PDF</th>
                                <th style="width: 5%;">แบบคำชี้แจงการปรับแก้ไขบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($data as $key => $value)
                                <tr class="text-center">
                                    <td>{{ $value->id }}</td>
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
                                            <a target="_blank" href="{{ Storage::url($value->word_path) }}">WORD-2</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->pdf))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->pdf_path) }}">PDF-2</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->statement))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->statement_path) }}">STM-2</a>
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
