@extends('frontend.layouts.master_frontend')

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

    <div>
        <h1>รายชื่อรายชื่อบทความ</h1>
    </div>
    <div class="panel">
        <div class="body">
            <div class="input-group">
                <label for="search">ค้นหาบทความ</label>
                <input type="text" class="form-control" name="search" id="search"
                    placeholder="ค้นหาผ่านลำดับ, ชื่อบทความ/ผู้นำเสนอ, สังกัด/หน่วยงาน, Slip, Word, Pdf">
            </div>
        </div>
    </div>
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
                        <select name="topic_status" class="form-select" onchange="open_modal(this, 'เปลี่ยนสถานะ')">
                            @foreach ($topic_status as $status)
                            <option value="{{ $status->id }}" @if ($status->name == $value->topic_status)
                                selected
                                @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" value="{{ $value->topic_id }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-green rounded-0 text-white"
                            onclick="open_modal(this, 'รายละเอียด')">
                            รายละเอียด
                        </button>
                        <input type="hidden" value="{{ $value->topic_id }}">
                    </td>
                    <td>
                        @if ($value->status_id >= 7)
                        <div class="d-flex justify-content-around">
                            <div>
                                @if ($value->ext_word)
                                <a href="{{ Storage::url($value->path_word) }}" title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">
                                    <img width="40" src="{{ secure_asset('images/doc.png') }}"
                                        alt="{{ $value->ext_word }}"><br />
                                    <i style="font-size: 10px;">{{ $value->new_word }}</i><br />
                                </a>
                                @endif
                                <button type="button" class="btn btn-info rounded-0 text-white"
                                    onclick="open_modal(this, 'word')">
                                    @if ($value->ext_word)
                                    แก้ไข WORD
                                    @else
                                    ส่งไฟล์ WORD
                                    @endif
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
                            </div>
                            <div>
                                @if ($value->ext_pdf)
                                <a href="{{ Storage::url($value->path_pdf) }}" title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">
                                    <img width="40" src="{{ secure_asset('images/pdf.png') }}"
                                        alt="{{ $value->ext_pdf }}"><br />
                                    <i style="font-size: 10px;">{{ $value->new_pdf }}</i><br />
                                </a>
                                @endif
                                <button type="button" class="btn btn-warning rounded-0 text-white"
                                    onclick="open_modal(this, 'pdf')">
                                    @if ($value->ext_pdf)
                                    แก้ไข PDF
                                    @else
                                    ส่งไฟล์ PDF
                                    @endif
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
                            </div>
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
<!-- End Content -->

<div id="modal"></div>

@endsection