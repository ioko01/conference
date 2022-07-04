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
                                <th style="width: 30%;">ชื่อบทความ/ผู้นำเสนอผลงาน</th>
                                <th style="width: 10%;">สังกัด/หน่วยงาน</th>
                                <th style="width: 5%;">Slip<br />ชำระเงิน</th>
                                <th style="width: 5%;">ไฟล์<br />WORD</th>
                                <th style="width: 5%;">ไฟล์<br />PDF</th>
                                <th style="width: 10%;">สถานะบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                                <th style="width: 20%;">ส่งไฟล์ไปให้นักวิจัยแก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($data as $key => $value)
                                <tr class="text-center">
                                    <td>{{ $value->id }}</td>
                                    <td><strong>{{ $value->topic_th }}</strong>
                                        <br /><strong
                                            class="name-research text-small text-green">{{ str_replace('|', ', ', $value->presenter) }}</strong>
                                    </td>
                                    <td>
                                        {{ $value->institution }}
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
                                            <div>
                                                @foreach ($comments as $comment)
                                                    @if ($value->topic_id == $comment->comment_topic_id)
                                                        @if ($comment->comment_path)
                                                            <a target="_blank"
                                                                href="{{ Storage::url($comment->comment_path) }}"
                                                                title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">
                                                                <i style="font-size: 10px;"
                                                                    class="mb-0">{{ $comment->comment_name }}</i><br />
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <button type="button" class="btn btn-warning rounded-0 text-white w-100"
                                                    onclick="open_modal(this, 'file')">
                                                    อัพโหลดไฟล์
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                                @error('file_comment')
                                                    {{ $message }}
                                                @enderror

                                            </div>
                                        @else
                                            -
                                        @endif
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
