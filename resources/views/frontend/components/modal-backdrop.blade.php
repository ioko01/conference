@section('modal')

<!-- Modal PAYMENT Example -->
@foreach ($data as $value)
<div class="modal fade" id="payment-modal-example" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="ตัวอย่างการชำระเงิน" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">สลิปการชำระเงิน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img width="100%" src="{{ Storage::url($value->payment_path) }}" alt="{{ $value->payment }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0 text-white"
                    data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Modal PAYMENT -->
@foreach ($data as $value)
<form enctype="multipart/form-data" method="POST" @if ($value->payment_path)
    action="{{ route('employee.payment.update', ['payment_upload' => $value->topic_id]) }}"
    @else
    action="{{ route('employee.payment.store', ['payment_upload' => $value->topic_id]) }}"
    @endif class="modal fade"
    id="payment-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="ชำระเงิน"
    aria-hidden="true">

    @csrf
    @if ($value->payment_path)
    @method('PUT')
    @endif

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ชำระเงิน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="file" class="form-control @error('payment_upload') is-invalid @enderror"
                        name="payment_upload" id="payment_upload" accept=".jpg, .jpeg" onchange="image(this)">
                    @error('payment_upload')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date">วันที่ชำระเงิน</label>
                    <input type="datetime-local" name="date" id="date" class="form-control @error('date')
                                    is-invalid
                                @enderror">
                    @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address">ที่อยู่ผู้ชำระเงิน</label>
                    <textarea class="form-control @error('address')
                        is-invalid
                    @enderror" name="address" id="address" cols="30" rows="10"></textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
            </div>
        </div>
    </div>
</form>
@endforeach


<!-- Modal WORD -->
@foreach ($data as $value)
<form enctype="multipart/form-data" method="POST" @if ($value->word_path)
    action="{{ route('employee.word.update', ['word_upload' => $value->topic_id]) }}"
    @else
    action="{{ route('employee.word.store', ['word_upload' => $value->topic_id]) }}"
    @endif class="modal fade" id="word-modal"
    data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="อัพโหลดไฟล์ WORD"
    aria-hidden="true">

    @csrf
    @if ($value->word_path)
    @method('PUT')
    @endif

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ WORD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control @error('word_upload') is-invalid @enderror" name="word_upload"
                    id="word_upload" accept=".doc, .docx">
                @error('word_upload')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
            </div>
        </div>
    </div>
</form>
@endforeach

<!-- Modal PDF -->
@foreach ($data as $value)
<form enctype="multipart/form-data" method="POST" @if ($value->pdf_path)
    action="{{ route('employee.pdf.update', ['pdf_upload' => $value->topic_id]) }}"
    @else
    action="{{ route('employee.pdf.store', ['pdf_upload' => $value->topic_id]) }}"
    @endif class="modal fade" id="pdf-modal"
    data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="อัพโหลดไฟล์ PDF"
    aria-hidden="true">

    @csrf
    @if ($value->pdf_path)
    @method('PUT')
    @endif

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" class="form-control @error('pdf_upload')) is-invalid @enderror" name="pdf_upload"
                    id="pdf_upload" accept=".pdf">
                @error('pdf_upload')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
            </div>
        </div>
    </div>
</form>
@endforeach




<!-- Modal DETAIL -->
<div class="modal fade" id="detail" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="รายละเอียด" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดทั้งหมด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @foreach ($data as $value)
                <div class="text-end">
                    <a href="{{ route('employee.research.edit', ['topic_id' => $value->topic_id]) }}"
                        class="text-warning">
                        <i class="fas fa-edit"></i> แก้ไขรายละเอียด</a>
                </div>
                <div class="mb-3">
                    <strong class="text-green">รหัสบทความ: </strong><span class="text-dark">{{ $value->topic_id
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สถานะบทความ: </strong><span class="text-dark">{{ $value->topic_status
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาไทย: </strong><span class="text-dark">{{ $value->topic_th
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาอังกฤษ: </strong><span class="text-dark">{{
                        $value->topic_en }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อผู้นำเสนอบทความ: </strong><span class="text-dark">{{
                        $value->presenter }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">กลุ่มบทความ: </strong><span class="text-dark">{{ $value->faculty
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สาขาย่อย: </strong><span class="text-dark">{{ $value->branch }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชนิดบทความ: </strong><span class="text-dark">{{ $value->degree }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">รูปแบบการนำเสนอ: </strong><span class="text-dark">{{ $value->present
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">เบอร์โทร: </strong><span class="text-dark">{{ $value->phone }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">อีเมล: </strong><span class="text-dark">{{ $value->email }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สังกัด/หน่วยงาน: </strong><span class="text-dark">{{ $value->institution
                        }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ที่อยู่: </strong><span class="text-dark">{{ $value->address }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">โควต้าเจ้าภาพร่วม: </strong><span class="text-dark">
                        @if ($value->kota)
                        {{ $value->kota }}
                        @else
                        -
                        @endif
                    </span>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endsection