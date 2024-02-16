@extends('frontend.layouts.master_frontend')

@section('content')
    <!-- Content -->
    <div class="bg-white text-blue p-5 my-5">
        <div class="inner-content-header">
            <h4 class="text-center fw-bold"><i class="nav-icon fas fa-1x fa-book"></i> รายชื่อบทความ <br />
                @if ($conference)
                    {{ $conference->name }}
                @endif
            </h4>
            <h4 class="text-primary py-3">
                {{ config('app.name') }}
            </h4>
        </div>

        <div class="col-md-12 mx-auto table-responsive">
            <table class="dataTable table w-100">
                <thead>
                    <tr class="text-center">
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
                                @if ($value->note)
                                    <strong style="font-size: 12px" class="text-danger">
                                        *หมายเหตุ : {{ $value->note }}
                                    </strong>
                                    <br />
                                @endif
                                <strong style="font-size: 12px" class="text-warning">
                                    รหัสบทความ : {{ $value->topic_id }}
                                </strong>
                                <br />
                                <strong>{!! $value->topic_th !!}</strong>
                                <br />
                                <strong><span class="name-research text-small text-green">ผู้นำเสนอ :
                                        {{ str_replace('!!', '', str_replace('ดร.', ' ดร.', str_replace('|', ', ', $value->presenter))) }}</span></strong>
                                <br />
                                <strong style="font-size: 12px" class="text-bluesky">
                                    รูปแบบบทความ : {{ $value->present }}
                                </strong>
                            </td>
                            <td>
                                <h1 class="text-danger text-center">
                                    @if ($value->status_id >= 4)
                                        <strong class="text-small text-warning">{{ $value->topic_status }}</strong>
                                    @else
                                        @if (countDate($value->created_at, 1, 'days'))
                                            <strong class="text-small text-warning">{{ $value->topic_status }}</strong>
                                        @else
                                            @if ($value->position_id === 1)
                                                <strong class="text-small text-green">บุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                                                    <br />ไม่ต้องชำระเงิน</strong>
                                            @elseif($value->position_id === 3)
                                                <strong class="text-small text-green">โควต้าเจ้าภาพร่วม
                                                    <br />ไม่ต้องชำระเงิน</strong>
                                            @else
                                                @if ($value->payment)
                                                    <span class="text-small text-green">ชำระเงินแล้ว</span>
                                                @else
                                                    <span class="text-small text-danger">ค้างชำระเงิน</span>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </h1>
                            </td>
                            <td>
                                @if (isset($value->payment_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->slip_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->slip_ext }}">
                                    <p class="mb-0">{{ $value->payment }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->slip_update, true) }}</i>
                                    <button type="button" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        onclick="open_modal(this, 'payment_example', null, '{{ Storage::url($value->payment_path) }}')">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ชำระเงิน
                                            </strong>
                                        </h1>
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
                                                <h1 class="text-danger text-center">
                                                    <strong style="font-size: calc(.1vw + 10px);">
                                                        ไม่สามารถชำระเงินได้แล้ว
                                                    </strong>
                                                </h1>
                                            @endif
                                        @else
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    สิ้นสุดเวลาการชำระเงิน
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ชำระเงิน
                                            </strong>
                                        </h1>
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
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง
                                            </strong>
                                        </h1>

                                    </div>
                                @endif
                            </td>
                            <td>
                                @if (isset($value->word_path))
                                    <img width="40"
                                        src="{{ asset("images/$value->word_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->word_ext }}">
                                    <p class="mb-0">{{ $value->word }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->word_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->word_path) }}">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    สิ้นสุดเวลาการส่งบทความ
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ส่งบทความ
                                            </strong>
                                        </h1>
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    สิ้นสุดเวลาการส่งบทความ
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ส่งบทความ
                                            </strong>
                                        </h1>
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
                                        src="{{ asset("images/$value->pdf_ext.webp", env('REDIRECT_HTTPS')) }}"
                                        alt="{{ $value->pdf_ext }}">
                                    <p class="mb-0">{{ $value->pdf }}</p>
                                    <i style="font-size: 10px;">แก้ไขครั้งล่าสุด
                                        {{ thaiDateFormat($value->pdf_update, true) }}</i>
                                    <a target="_blank" class="btn btn-green text-white rounded-0 w-100 my-1"
                                        href="{{ Storage::url($value->pdf_path) }}">
                                        <i class="fas fa-search"></i> ดูตัวอย่าง
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    สิ้นสุดเวลาการส่งบทความ
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ส่งบทความ
                                            </strong>
                                        </h1>
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
                                            <h1 class="text-danger text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    สิ้นสุดเวลาการส่งบทความ
                                                </strong>
                                            </h1>
                                        @endif
                                    @else
                                        <h1 class="text-danger text-center">
                                            <strong style="font-size: calc(.1vw + 10px);">
                                                ยังไม่เปิดให้ส่งบทความ
                                            </strong>
                                        </h1>
                                    @endif
                                @endif

                                @if (session('pdf_upload'))
                                    <strong class="text-red">ไม่สามารถอัพโหลดไฟล์ได้ กรุณาลองใหม่อีกครั้ง</strong>
                                @endif

                            </td>
                            <td>
                                @if ($value->research_passed == 1 || $value->research_passed == 2)
                                    @if ($value->status_id >= 7)
                                        @forelse ($comments as $key => $comment)
                                            @if ($comment->comment_topic_id == $value->topic_id)
                                                <div class="text-start">
                                                    <a class="text-green" target="_blank"
                                                        href="{{ Storage::url($comment->comment_path) }}">
                                                        &bull; <i
                                                            style="font-size: 10px;">{{ $comment->comment_name }}</i>
                                                    </a>
                                                </div>
                                                <div style="border-bottom: 1px dotted #ccc;" class="my-2"></div>
                                            @endif
                                        @empty
                                            <h1 class="text-warning text-center">
                                                <strong style="font-size: calc(.1vw + 10px);">
                                                    (รอบทความแก้ไขจากผู้ทรงคุณวุฒิ)
                                                </strong>
                                            </h1>
                                        @endforelse
                                    @else
                                        -
                                    @endif
                                @else
                                    <h1 class="text-warning text-center">
                                        <strong style="font-size: calc(.1vw + 10px);">
                                            (อยู่ในระหว่างการพิจารณา)
                                        </strong>
                                    </h1>
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
