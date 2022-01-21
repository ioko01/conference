@extends('frontend.layouts.master_frontend')

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
    <div class="inner-content-header">
        <h4 class="text-center">รายชื่อรายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h4>
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
                    <th style="width: 30%;">ชื่อบทความ/ผู้วิจัย</th>
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
                        <button class="btn btn-warning rounded-0 text-white"
                            onclick="document.getElementById('payment').click()">
                            ชำระเงิน
                            <input style="display: none;" type="file" name="payment" id="payment" accept=".jpg, .jpeg">
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary rounded-0 text-white"
                            onclick="document.getElementById('word').click()">
                            อัพโหลดไฟล์ WORD
                            <input style="display: none;" type="file" name="word" id="word" accept=".doc, .docx">
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-secondary rounded-0 text-white"
                            onclick="document.getElementById('pdf').click()">
                            อัพโหลดไฟล์ PDF
                            <input style="display: none;" type="file" name="pdf" id="pdf" accept=".pdf">
                        </button>
                        <span></span>
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-green rounded-0 text-white" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
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




<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดทั้งหมด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-green rounded-0 text-white">บันทึกและปิด</button>
            </div>
        </div>
    </div>
</div>
@endsection