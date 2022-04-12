@extends('frontend.layouts.master_frontend')
@include('frontend.components.modal-backdrop')

@section('content')
<!-- Content -->
<div class="bg-white text-blue p-5 my-5">
    <div class="inner-content-header">
        <h2 class="text-center">รายชื่อบทความ ในงานการประชุมวิชาการ ราชภัฏเลยวิชาการ ครั้งที่ 8</h2>
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
                    <th style="width: 15%;">ชื่อบทความ/ผู้วิจัย</th>
                    <th style="width: 10%;">สถานะ</th>
                    <th style="width: 10%;">ชำระเงิน</th>
                    <th style="width: 10%;">ไฟล์ WORD</th>
                    <th style="width: 10%;">ไฟล์ PDF</th>
                    <th style="width: 10%;">ไฟล์แก้ไขจากผู้ทรงฯ</th>
                    <th style="width: 5%;">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $value)
                <tr class="text-center">
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->topic_th }}
                        <br /><span class="name-research text-small text-green">{{ str_replace('|', ', ', $value->presenter) }}</span>
                    </td>
                    <td>
                        <strong class="text-red">{{ $value->topic_status }}</strong>
                    </td>
                    <td>
                        @if (isset($value->payment_path))
                        <img width="40" src="{{ asset("images/$value->slip_ext.png", env('REDIRECT_HTTPS')) }}"
                        alt="{{ $value->slip_ext }}">
                        <p class="mb-0">{{ $value->payment }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->slip_update))
                            }}</i>
                        <button type="button" class="btn btn-green text-white rounded-0 w-100 my-1"
                            data-bs-toggle="modal" data-bs-target="#payment-modal-example">
                            ดูตัวอย่าง
                        </button>
                        @if ($value->status_id <= 4) <button type="button"
                            class="btn btn-warning text-white rounded-0 w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#payment-modal">
                            แก้ไขสลิปชำระเงิน
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-warning text-white rounded-0 w-100"
                                data-bs-toggle="modal" data-bs-target="#payment-modal">
                                ชำระเงิน
                            </button>
                            @endif

                            @if (session('payment_upload') || session('date') || session('address'))
                            <div class="alert alert-error">
                                <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if (isset($value->word_path))
                        <img width="40" src="{{ asset("images/$value->word_ext.png", env('REDIRECT_HTTPS')) }}"
                        alt="{{ $value->word_ext }}">
                        <p class="mb-0">{{ $value->word }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->word_update))
                            }}</i>
                        <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->word_path) }}">
                            ดูตัวอย่าง
                        </a>
                        @if ($value->status_id <= 4) <button type="button"
                            class="btn btn-warning text-white rounded-0 w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#word-modal">
                            แก้ไขไฟล์ WORD
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-primary rounded-0 w-100" data-bs-toggle="modal"
                                data-bs-target="#word-modal">
                                อัพโหลดไฟล์ WORD
                            </button>
                            @endif

                            @if(session('word_upload'))
                            <div class="alert alert-error">
                                <strong class="text-red">{{ $message }}</strong>
                            </div>
                            @endif

                    </td>
                    <td>
                        @if (isset($value->pdf_path))
                        <img width="40" src="{{ asset("images/$value->pdf_ext.png", env('REDIRECT_HTTPS')) }}"
                        alt="{{ $value->pdf_ext }}">
                        <p class="mb-0">{{ $value->pdf }}</p>
                        <i style="font-size: 10px;">แก้ไขครั้งล่าสุด {{ date('d-m-Y H:i:s',
                            strtotime($value->pdf_update))
                            }}</i>
                        <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                            href="{{ Storage::url($value->pdf_path) }}">
                            ดูตัวอย่าง
                        </a>
                        @if ($value->status_id <= 4) <button type="button"
                            class="btn btn-warning text-white rounded-0 w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#pdf-modal">
                            แก้ไขไฟล์ PDF
                            </button>
                            @endif
                            @else
                            <button type="button" class="btn btn-secondary rounded-0 w-100" data-bs-toggle="modal"
                                data-bs-target="#pdf-modal">
                                อัพโหลดไฟล์ PDF
                            </button>
                            @endif

                            @if(session('pdf_upload'))
                            <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                            @endif

                    </td>
                    <td>
                        @if ( $value->status_id >= 8 )
                        @forelse ($comments as $key => $comment)
                        <div class="text-start">
                            <a target="_blank" href="{{ Storage::url($comment->comment_path)}}">
                                {{ ++$key }}. <i style="font-size: 10px;">{{ $comment->comment_name }}</i>
                            </a>
                        </div>
                        @empty
                        <strong class="text-warning">(รอบทความแก้ไขจากผู้ทรงคุณวุฒิ)</strong>
                        @endforelse
                        @else
                        -
                        @endif
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