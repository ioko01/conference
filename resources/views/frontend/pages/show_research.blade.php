@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
<!-- Breadcrumb -->
<div class="py-5">
    <div class="row text-end m-0">
        <div class="col-5 col-md-4 col-lg-3 col-xl-2 bg-white breadcrumb">
            <p><strong>ลงทะเบียน > รายชื่อบทความ</strong></p>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Content -->
<div class="bg-white text-blue p-5 mb-5">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        เพิ่มบทความสำเร็จ
    </div>
    @endif

    <div class="inner-content-header">
        <h2 class="text-center">รายชื่อรายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
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
                    placeholder="ค้นหาผ่านลำดับ, รหัสบทความ, บทความ/ผู้วิจัย, สังกัด/กลุ่มคณะ, สถานะ, รูปแบบ">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="list table responsive hover">
            <thead>
                <tr class="text-center pagination-header">
                    <th style="width: 5%;">#</th>
                    <th style="width: 20%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 15%;">สถานะ</th>
                    <th style="width: 10%;">ชำระเงิน</th>
                    <th style="width: 10%;">ไฟล์ WORD</th>
                    <th style="width: 10%;">ไฟล์ PDF</th>
                    <th style="width: 15%;">รายละเอียด</th>
                    <th style="width: 10%;">บทความแก้ไข</th>
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
                        <strong class="text-red">{{ $value->topic_status }}</strong>
                    </td>
                    <td>
                        @if (isset($value->payment_path))
                        <img width="40" src="{{ asset('images/jpg.png', env('REDIRECT_HTTPS')) }}"
                            alt="{{ $value->slip_ext }}">
                        <p>{{ $value->payment }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->slip_update))
                            }}</i>
                        @if ($value->status_id <= 4) <button type="button"
                            class="btn btn-green text-white rounded-0 w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#payment-modal-example">
                            ดูตัวอย่าง
                            </button>
                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                data-bs-toggle="modal" data-bs-target="#payment-modal">
                                แก้ไขสลิปชำระเงิน
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-warning text-white rounded-0 w-100"
                                data-bs-toggle="modal" data-bs-target="#payment-modal">
                                ชำระเงิน
                            </button>
                            @endif

                            @error('payment_upload')
                            <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror
                    </td>
                    <td>
                        @if (isset($value->word_path))
                        <img width="40" src="{{ asset('images/doc.png', env('REDIRECT_HTTPS')) }}"
                            alt="{{ $value->word_ext }}">
                        <p>{{ $value->word }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->word_update))
                            }}</i>
                        @if ($value->status_id <= 4) <a class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->word_path) }}">
                            ดูตัวอย่าง
                            </a>
                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                data-bs-toggle="modal" data-bs-target="#word-modal">
                                แก้ไขไฟล์ WORD
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-primary rounded-0 w-100" data-bs-toggle="modal"
                                data-bs-target="#word-modal">
                                อัพโหลดไฟล์ WORD
                            </button>
                            @endif

                            @error('word_upload')
                            <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror

                    </td>
                    <td>

                        @if (isset($value->pdf_path))
                        <img width="40" src="{{ asset('images/pdf.png', env('REDIRECT_HTTPS')) }}"
                            alt="{{ $value->pdf_ext }}">
                        <p>{{ $value->pdf }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->pdf_update))
                            }}</i>
                        @if ($value->status_id <= 4) <a class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->pdf_path) }}">
                            ดูตัวอย่าง
                            </a>
                            <button type="button" class="btn btn-warning text-white rounded-0 w-100 my-1"
                                data-bs-toggle="modal" data-bs-target="#pdf-modal">
                                แก้ไขไฟล์ PDF
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-secondary rounded-0 w-100" data-bs-toggle="modal"
                                data-bs-target="#pdf-modal">
                                อัพโหลดไฟล์ PDF
                            </button>
                            @endif

                            @error('pdf_upload')
                            <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @enderror

                    </td>
                    <td>
                        <button type="button" class="btn btn-green rounded-0 text-white" data-bs-toggle="modal"
                            data-bs-target="#detail">
                            รายละเอียด
                        </button>
                    </td>
                    <td>
                        @if ( $value->edit_research_update )
                        @if (isset($value->path_word) && isset($value->path_pdf))
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->edit_research_update))
                            }}</i>
                        <a class="btn btn-primary rounded-0 w-100 my-1" href="{{ Storage::url($value->path_word) }}"
                            target="_blank">ดาวน์โหลด WORD</a>
                        <a class="btn btn-primary rounded-0 w-100 my-1" href="{{ Storage::url($value->path_pdf) }}"
                            target="_blank">ดาวน์โหลด PDF</a>
                        @else
                        -
                        @endif
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="8">ไม่มีบทความของท่าน</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- End Content -->

@yield('modal')

@endsection