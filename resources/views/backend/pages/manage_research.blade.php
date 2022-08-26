@extends('backend.layouts.master_backend')

@section('content')

    <!-- Content -->
    <div class="card">
        <div class="card-content">
            <div class="card-header d-flex align-items-center justify-content-between w-100">
                <h1>จัดการรายชื่อรายชื่อบทความ</h1>
                <div class="ms-auto">
                    <a href="{{ route('researchs.export') }}" class="btn btn-info rounded-0"><i class="fas fa-file-export"></i>
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
                                <th style="width: 30%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 5%;">Slip<br />ชำระเงิน</th>
                                <th style="width: 5%;">ไฟล์<br />WORD</th>
                                <th style="width: 5%;">ไฟล์<br />PDF</th>
                                <th style="width: 10%;">สถานะบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                                <th style="width: 20%;">ส่งไฟล์ไปให้นักวิจัยแก้ไข</th>
                                <th style="width: 10%;">แก้ไข</th>
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
                                        <strong style="font-size: 12px" class="text-primary">สังกัด /
                                            หน่วยงาน : {{ $value->institution }}</strong>
                                        <br />
                                        <strong>
                                            {{ $value->topic_th }}@if ($value->user_id == auth()->user()->id)
                                                <i class="text-bluesky"> (ฉัน)</i>
                                            @endif
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-green">ผู้นำเสนอ :
                                            {{ str_replace('|', ', ', $value->presenter) }}</strong>
                                        <br />
                                        <p class="text-secondary">
                                            <i style="font-size: 10px" class="d-block">อัพโหลด
                                                {{ thaiDateFormat($value->created_at, true, true) }}</i>
                                            <i style="font-size: 10px" class="d-block">แก้ไข
                                                {{ thaiDateFormat($value->updated_at, true, true) }}</i>
                                        </p>
                                    </td>
                                    <td>
                                        @if (empty($value->payment))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->payment_path) }}">SLIP</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->word))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->word_path) }}">WORD</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (empty($value->pdf))
                                            -
                                        @else
                                            <a target="_blank" href="{{ Storage::url($value->pdf_path) }}">PDF</a>
                                        @endif
                                    </td>
                                    <td>
                                        <select name="topic_status" class="form-select"
                                            onchange="open_modal(this, 'change_status')">
                                            @foreach ($topic_status as $status)
                                                <option value="{{ $status->id }}"
                                                    @if ($status->name == $value->topic_status) selected @endif>{{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success rounded-0 text-white"
                                            onclick="open_modal(this, 'detail')">
                                            รายละเอียด
                                        </button>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                    <td>
                                        @if ($value->status_id >= 7)
                                            <div class="text-start">
                                                @foreach ($comments as $comment)
                                                    @if ($value->topic_id == $comment->comment_topic_id)
                                                        @if ($comment->comment_path)
                                                            <a target="_blank" class="text-info"
                                                                href="{{ Storage::url($comment->comment_path) }}"
                                                                title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">
                                                                &bull; <i style="font-size: 10px;"
                                                                    class="mb-0">{{ $comment->comment_name }}</i><br />
                                                            </a>
                                                            <div style="border-bottom: 1px dotted #ccc;" class="my-2"></div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <button type="button" class="btn btn-info rounded-0 text-white w-100"
                                                    onclick="open_modal(this, 'file')">
                                                    <i class="fas fa-upload"></i> อัพโหลดไฟล์
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                                <input type="hidden" name="error_file_comment" id="error_file_comment"
                                                    @error('file_comment') value="{{ $message }}" @enderror
                                                    @error('file_comment.*') value="{{ $message }}" @enderror>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.research.edit', $value->topic_id) }}"
                                            class="btn btn-warning text-white rounded-0"><i class="nav-icon fa fa-edit"></i>
                                            แก้ไข</a>
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
