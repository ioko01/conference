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
                    <th style="width: 20%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 10%;">สถานะ</th>
                    <th style="width: 15%;">ชำระเงิน</th>
                    <th style="width: 15%;">ไฟล์ WORD</th>
                    <th style="width: 15%;">ไฟล์ PDF</th>
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
                        <strong class="text-red">{{ $value->topic_status }}</strong>
                    </td>
                    <td>
                        @if (isset($value->payment_path))
                        <img width="100%" src="{{ Storage::url($value->payment_path) }}" alt="slip">
                        <div class="d-flex">
                            <button type="button" class="btn btn-green text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#payment-modal">
                                ดูตัวอย่าง
                            </button>
                            <button type="button" class="btn btn-warning text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#payment-modal">
                                แก้ไขสลิปชำระเงิน
                            </button>
                        </div>
                        @else
                        <button type="button" class="btn btn-warning text-white rounded-0 w-100" data-bs-toggle="modal"
                            data-bs-target="#payment-modal">
                            ชำระเงิน
                        </button>
                        @endif

                        @error('payment_upload')
                        <strong>{{ $message }}</strong>
                        @enderror

                    </td>
                    <td>

                        @if (isset($value->word_path))
                        {{ $value->word }}
                        <div class="d-flex">
                            <button type="button" class="btn btn-green text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#word-modal">
                                ดูตัวอย่าง
                            </button>
                            <button type="button" class="btn btn-warning text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#word-modal">
                                แก้ไขไฟล์ WORD
                            </button>
                        </div>
                        @else
                        <button type="button" class="btn btn-primary rounded-0 w-100" data-bs-toggle="modal"
                            data-bs-target="#word-modal">
                            อัพโหลดไฟล์ WORD
                        </button>
                        @endif

                        @error('word_upload')
                        <strong>{{ $message }}</strong>
                        @enderror

                    </td>
                    <td>

                        @if (isset($value->pdf_path))
                        {{ $value->pdf }}
                        <div class="d-flex">
                            <button type="button" class="btn btn-green text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#pdf-modal">
                                ดูตัวอย่าง
                            </button>
                            <button type="button" class="btn btn-warning text-white rounded-0" data-bs-toggle="modal"
                                data-bs-target="#pdf-modal">
                                แก้ไขไฟล์ PDF
                            </button>
                        </div>
                        @else
                        <button type="button" class="btn btn-secondary rounded-0 w-100" data-bs-toggle="modal"
                            data-bs-target="#pdf-modal">
                            อัพโหลดไฟล์ PDF
                        </button>
                        @endif

                        @error('pdf_upload')
                        <strong>{{ $message }}</strong>
                        @enderror
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
                    <td colspan="7">ไม่มีบทความของท่าน</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- End Content -->

@yield('modal')

@endsection