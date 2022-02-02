@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

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
                        <select name="topic_status" id="topic_status" class="form-select">
                            @foreach ($topic_status as $status)
                            <option value="{{ $status->id }}" 
                            @if ($status->name == $value->topic_status)
                                selected
                            @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-green rounded-0 text-white" data-bs-toggle="modal"
                            data-bs-target="#detail">
                            รายละเอียด
                        </button>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="6">ไม่มีบทความของท่าน</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- End Content -->

@yield('modal')

@endsection