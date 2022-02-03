@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal')

@section('content')
    <!-- Breadcrumb -->
    <div class="py-5">
        <div class="row text-end m-0">
            <div class="col-5 col-md-4 col-lg-3 col-xl-2 bg-white breadcrumb">
                <p><strong>แอดมิน > จัดการบทความ</strong></p>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Content -->
    <div class="bg-white text-blue p-5 mb-5">
        <div class="inner-content-header">
            <h2 class="text-center">จัดการรายชื่อรายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
            <h4 class="text-green py-3">
                LRU Conference 2022
            </h4>
        </div>
        <div class="container">
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
            <table class="list table responsive hover">
                <thead>
                    <tr class="text-center pagination-header">
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">ชื่อบทความ/ผู้นำเสนอผลงาน</th>
                        <th style="width: 11%;">สังกัด/หน่วยงาน</th>
                        <th style="width: 8%;">Slip ชำระเงิน</th>
                        <th style="width: 8%;">ไฟล์ WORD</th>
                        <th style="width: 8%;">ไฟล์ PDF</th>
                        <th style="width: 20%;">สถานะบทความ</th>
                        <th style="width: 15%;">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($data as $key => $value)
                        <tr class="text-center">
                            <td>{{ ++$key }}</td>
                            <td>{{ $value->topic_th }}
                                <br /><span class="name-research text-small text-green">{{ $value->presenter }}</span>
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
                                    onchange="open_update_status_modal(this, 'เปลี่ยนสถานะ')">
                                    @foreach ($topic_status as $status)
                                        <option value="{{ $status->id }}" @if ($status->name == $value->topic_status)
                                            selected
                                    @endif>{{ $status->name }}</option>
                    @endforeach
                    </select>
                    <input type="hidden" value="{{ $value->topic_id }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-green rounded-0 text-white" data-bs-toggle="modal"
                            data-bs-target="#detail_{{ $key }}">
                            รายละเอียด
                        </button>
                    </td>
                    </tr>
                    <div class="modal fade" id="detail_{{ $key }}" data-bs-backdrop="static"
                        data-bs-keyboard="true" tabindex="-1" aria-labelledby="รายละเอียด" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดทั้งหมด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong class="text-green">รหัสบทความ: </strong><span
                                            class="text-dark">{{ $value->topic_id }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">สถานะบทความ: </strong><span
                                            class="text-dark">{{ $value->topic_status }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">ชื่อบทความภาษาไทย: </strong><span
                                            class="text-dark">{{ $value->topic_th }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">ชื่อบทความภาษาอังกฤษ: </strong><span
                                            class="text-dark">{{ $value->topic_en }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">ชื่อผู้นำเสนอบทความ: </strong><span
                                            class="text-dark">{{ $value->presenter }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">กลุ่มบทความ: </strong><span
                                            class="text-dark">{{ $value->faculty }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">สาขาย่อย: </strong><span
                                            class="text-dark">{{ $value->branch }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">ชนิดบทความ: </strong><span
                                            class="text-dark">{{ $value->degree }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">รูปแบบการนำเสนอ: </strong><span
                                            class="text-dark">{{ $value->present }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">เบอร์โทร: </strong><span
                                            class="text-dark">{{ $value->phone }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">อีเมล: </strong><span
                                            class="text-dark">{{ $value->email }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">สังกัด/หน่วยงาน: </strong><span
                                            class="text-dark">{{ $value->institution }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">ที่อยู่: </strong><span
                                            class="text-dark">{{ $value->address }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-green">โควต้าเจ้าภาพร่วม: </strong><span
                                            class="text-dark">
                                            @if ($value->kota)
                                                {{ $value->kota }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-0"
                                        data-bs-dismiss="modal">ปิด</button>
                                    <button type="button" class="btn btn-green rounded-0 text-white">บันทึกและปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr class="text-center">
                        <td colspan="6">ไม่มีบทความ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Content -->

    <div id="modal"></div>

@endsection
