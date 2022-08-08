@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h2 class="text-center">รายชื่อบทความ <br />{{ $conference->name }}</h2>
            <h4 class="text-green py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div>
            <h1>รายชื่อบทความ</h1>
        </div>
        <div class="panel">
            <div class="body">
                <div class="input-group">
                    <label for="search">ค้นหาบทความ</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="ค้นหาบทความ">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="list table responsive hover">
                <thead>
                    <tr class="text-center pagination-header">
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;" class="text-start">รายละเอียดบทความ</th>
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
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start">
                                <strong style="font-size: 12px" class="text-bluesky">{{ $value->present }}</strong>
                                <br />
                                <strong>{{ $value->topic_th }}</strong>
                                <br />
                                <strong><span
                                        class="name-research text-small text-green">{{ str_replace('|', ', ', $value->presenter) }}</span></strong>
                            </td>
                            <td>
                                <strong class="text-red">{{ $value->topic_status }}</strong>
                            </td>
                            <td>
                                @if (isset($value->payment_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->slip_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->slip_ext }}">
                                    <p class="mb-0">{{ $value->payment }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->slip_update, true) }}</i>
                                    <button type="button" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        onclick="open_modal(this, 'payment_example', null, '{{ Storage::url($value->payment_path) }}')">
                                        ดูตัวอย่าง
                                    </button>
                                    @if ($value->status_payment)
                                        @if (endDate('end_payment')->day >= 0)
                                            @if ($value->status_id < 4)
                                                <button type="button"
                                                    class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                    onclick="open_modal(this, 'payment', 'PUT' @if ($value->payment_path) , '{{ $value->payment_path }}' @endif , 'PUT')">
                                                    แก้ไขสลิปชำระเงิน
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                            @endif
                                        @else
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ชำระเงิน</strong>
                                    @endif
                                @else
                                    @if ($value->status_payment)
                                        @if (endDate('end_payment')->day >= 0 || $value->word_path)
                                            @if ($value->status_id <= 4)
                                                <button type="button" class="btn btn-warning text-white rounded-0 w-100"
                                                    onclick="open_modal(this, 'payment', null @if ($value->payment_path) , '{{ $value->payment_path }}' @endif)">
                                                    ชำระเงิน
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                            @else
                                                <strong class="text-red">สิ้นสุดเวลาการชำระเงิน</strong>
                                            @endif
                                        @else
                                            <strong class="text-red">สิ้นสุดเวลาการชำระเงิน</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ชำระเงิน</strong>
                                    @endif
                                @endif

                                <input id="error_payment" type="hidden" name="error_payment"
                                    value="@error('payment_upload') {{ $message }} @enderror">

                                <input id="error_date" type="hidden" name="error_date"
                                    value="@error('date') {{ $message }} @enderror">

                                <input id="error_address" type="hidden" name="error_address"
                                    value="@error('address') {{ $message }} @enderror">

                                @if (session('payment_upload') || session('date') || session('address'))
                                    <div class="alert alert-error">
                                        <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if (isset($value->word_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->word_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->word_ext }}">
                                    <p class="mb-0">{{ $value->word }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->word_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                    @if ($value->status_research)
                                        @if (endDate('end_research')->day >= 0)
                                            @if ($value->status_id <= 4)
                                                <button type="button"
                                                    class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                    onclick="open_modal(this, 'send_word', 'PUT')">
                                                    แก้ไขไฟล์ WORD
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                            @endif
                                        @else
                                            <strong class="text-red">สิ้นสุดเวลาการส่งบทความ</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ส่งบทความ</strong>
                                    @endif
                                @else
                                    @if ($value->status_research)
                                        @if (endDate('end_research')->day >= 0)
                                            <button type="button" class="btn btn-primary rounded-0 w-100"
                                                onclick="open_modal(this, 'send_word')">
                                                อัพโหลดไฟล์ WORD
                                            </button>
                                            <input type="hidden" value="{{ $value->topic_id }}">
                                        @else
                                            <strong class="text-red">สิ้นสุดเวลาการส่งบทความ</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ส่งบทความ</strong>
                                    @endif
                                @endif

                                @if (session('word_upload'))
                                    <div class="alert alert-error">
                                        <strong class="text-red">{{ $message }}</strong>
                                    </div>
                                @endif

                            </td>
                            <td>
                                @if (isset($value->pdf_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->pdf_ext.png", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->pdf_ext }}">
                                    <p class="mb-0">{{ $value->pdf }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->pdf_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->pdf_path) }}">
                                        ดูตัวอย่าง
                                    </a>
                                    @if ($value->status_research)
                                        @if (endDate('end_research')->day >= 0)
                                            @if ($value->status_id <= 4)
                                                <button type="button"
                                                    class="btn btn-warning text-white rounded-0 w-100 my-1"
                                                    onclick="open_modal(this, 'send_pdf', 'PUT')">
                                                    แก้ไขไฟล์ PDF
                                                </button>
                                                <input type="hidden" value="{{ $value->topic_id }}">
                                            @endif
                                        @else
                                            <strong class="text-red">สิ้นสุดเวลาการส่งบทความ</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ส่งบทความ</strong>
                                    @endif
                                @else
                                    @if ($value->status_research)
                                        @if (endDate('end_research')->day >= 0)
                                            <button type="button" class="btn btn-secondary rounded-0 w-100"
                                                onclick="open_modal(this, 'send_pdf')">
                                                อัพโหลดไฟล์ PDF
                                            </button>
                                            <input type="hidden" value="{{ $value->topic_id }}">
                                        @else
                                            <strong class="text-red">สิ้นสุดเวลาการส่งบทความ</strong>
                                        @endif
                                    @else
                                        <strong class="text-red">ยังไม่เปิดให้ส่งบทความ</strong>
                                    @endif
                                @endif

                                @if (session('pdf_upload'))
                                    <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                                @endif

                            </td>
                            <td>
                                @if ($value->status_id >= 8)
                                    @forelse ($comments as $key => $comment)
                                        <div class="text-start">
                                            <a target="_blank" href="{{ Storage::url($comment->comment_path) }}">
                                                {{ ++$key }}. <i
                                                    style="font-size: 10px;">{{ $comment->comment_name }}</i>
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
                                <button type="button" class="btn btn-green rounded-0 text-white"
                                    onclick="open_modal(this, 'detail')">
                                    รายละเอียด
                                </button>
                                <input type="hidden" value="{{ $value->topic_id }}">
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

    <div id="modal"></div>

@endsection
