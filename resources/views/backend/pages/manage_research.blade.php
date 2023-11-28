@extends('backend.layouts.master_backend')

@section('content')
    <!-- Content -->

    <div class="card">
        <div class="card-content">
            <div class="bg-green card-header rounded-0">
                <strong><i class="nav-icon fas fa-cogs"></i> จัดการบทความ</strong>
            </div>

            <div class="card-body text-xs">
                <div class="text-end">
                    <button id="export" onclick="loading_export('researchs')" class="btn btn-info rounded-0 mb-3"><i
                            class="fas fa-file-export"></i> Export to Excel</button>
                    <strong class="text-red d-block mb-2">อาจใช้เวลาในการเขียนไฟล์หลายนาที</strong>
                    <input type="hidden" id="auth_id" value="{{ auth()->user()->id }}">
                </div>

                <div class="table-responsive">
                    <table style="color: inherit;" class="dataTable table w-100">
                        <thead>
                            <tr class="text-center pagination-header">
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;" class="text-start">รายละเอียดบทความ</th>
                                <th style="width: 5%;">Slip<br />ชำระเงิน</th>
                                <th style="width: 5%;">ไฟล์<br />WORD</th>
                                <th style="width: 5%;">ไฟล์<br />PDF</th>
                                <th style="width: 10%;">สถานะบทความ</th>
                                <th style="width: 10%;">รายละเอียด</th>
                                <th style="width: 10%;">ผู้ทรงคุณวุฒิ</th>
                                <th style="width: 10%;">ส่งไฟล์ไปให้นักวิจัยแก้ไข</th>
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
                                        <strong>
                                            {!! $value->topic_th !!}
                                        </strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-primary">สังกัด /
                                            หน่วยงาน : {{ $value->institution }}</strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-green">ผู้นำเสนอ :
                                            {{ str_replace('!!', '', str_replace('ดร.', ' ดร.', str_replace('|', ', ', $value->presenter))) }}</strong>
                                        <br />
                                        <strong style="font-size: 12px" class="text-bluesky">
                                            รูปแบบบทความ : {{ $value->present }}
                                        </strong>
                                        <br />
                                        <p class="text-secondary">
                                            <i style="font-size: 10px" class="d-block">อัพโหลด
                                                {{ thaiDateFormat($value->created_at, true, true) }}</i>
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
                                        @if (auth()->user()->is_admin == 3 || auth()->user()->is_admin == 2)
                                            <select id="select_{{ $value->topic_id }}" name="topic_status"
                                                class="form-select" onchange="open_modal(this, 'change_status')">

                                                @foreach ($topic_status as $status)
                                                    <option value="{{ $status->id }}"
                                                        @if ($status->name == $value->topic_status) selected="selected" @endif>
                                                        {{ $status->name }}

                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            -
                                        @endif

                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success rounded-0 text-white"
                                            onclick="open_modal(this, 'detail')">รายละเอียด</button>
                                        <input type="hidden" value="{{ $value->topic_id }}">
                                    </td>

                                    <td id="sug_{{ $value->topic_id }}">
                                        @if ($value->status_id >= 5)
                                            @php
                                                $data = [
                                                    'list_expert' => $expert,
                                                    'topic_id' => $value->topic_id,
                                                    'topic_th' => $value->topic_th,
                                                    'topic_en' => $value->topic_en,
                                                    'link' => Request::root() . '/suggestion/' . base64_encode($value->topic_id . '|' . $value->created_at),
                                                ];
                                            @endphp
                                            <button style="min-width: 100px;"
                                                class="btn rounded-0 btn-sm btn-warning text-white w-100 mb-3"
                                                onclick="open_modal_default('#modal', 'xl', 'ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ', '{{ json_encode($data) }}')">
                                                <i class="fas fa-search-plus"></i> ขยาย</button>
                                        @endif
                                    </td>
                                    <td id="{{ $value->topic_id }}">
                                        @if ($value->status_id >= 7)
                                            <div class="text-start">
                                                <button type="button"
                                                    class="btn btn-sm btn-info rounded-0 text-white w-100 mb-3"
                                                    onclick="open_modal(this, 'file')">

                                                    <i class="fas fa-upload"></i> อัพโหลด / ลบไฟล์

                                                </button>

                                                <input type="hidden" value="{{ $value->topic_id }}">

                                                <input type="hidden" name="error_file_comment" id="error_file_comment"
                                                    @error('file_comment') value="{{ $message }}" @enderror
                                                    @error('file_comment.*') value="{{ $message }}" @enderror>

                                                @foreach ($comments as $comment)
                                                    @if ($value->topic_id == $comment->comment_topic_id)
                                                        @if ($comment->comment_path)
                                                            <a target="_blank" class="text-info"
                                                                href="{{ Storage::url($comment->comment_path) }}"
                                                                title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">

                                                                &bull; <i style="font-size: 10px;" class="fst-normal"
                                                                    class="mb-0">{{ $comment->comment_name }}
                                                                    @if ($comment->comment_status == 'pass')
                                                                        &nbsp;<i class="fas fa-check text-green"></i>
                                                                    @elseif($comment->comment_status == 'notpass')
                                                                        &nbsp;<i class="fas fa-times text-red"></i>
                                                                    @endif
                                                                </i><br />

                                                            </a>

                                                            <div style="border-bottom: 1px dotted #ccc;" class="my-2">

                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach

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
