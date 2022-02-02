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
                <button type="button" class="btn btn-secondary rounded-0 text-white" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Modal PAYMENT -->
@foreach ($data as $value)
<form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.update', $value->topic_id) }}"
    class="modal fade" id="payment-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="ชำระเงิน" aria-hidden="true">
    @csrf
    @method('PUT')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">ชำระเงิน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="payment_upload" id="payment_upload" accept=".jpg, .jpeg"
                    onchange="image(this)">
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
<form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.update', $value->topic_id) }}" class="modal fade"
    id="word-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="อัพโหลดไฟล์ WORD"
    aria-hidden="true">
    @csrf
    @method('PUT')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ WORD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="word_upload" id="word_upload" accept=".doc, .docx">
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
<form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.update', $value->topic_id) }}" class="modal fade"
    id="pdf-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="อัพโหลดไฟล์ PDF"
    aria-hidden="true">
    @csrf
    @method('PUT')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="pdf_upload" id="pdf_upload" accept=".pdf">
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
                <div class="mb-3">
                    <strong class="text-green">รหัสบทความ: </strong><span class="text-dark">{{ $value->topic_id }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สถานะบทความ: </strong><span class="text-dark">{{ $value->topic_status }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาไทย: </strong><span class="text-dark">{{ $value->topic_th }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาอังกฤษ: </strong><span class="text-dark">{{ $value->topic_en }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อผู้นำเสนอบทความ: </strong><span class="text-dark">{{ $value->presenter }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">กลุ่มบทความ: </strong><span class="text-dark">{{ $value->faculty }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สาขาย่อย: </strong><span class="text-dark">{{ $value->branch }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชนิดบทความ: </strong><span class="text-dark">{{ $value->degree }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">รูปแบบการนำเสนอ: </strong><span class="text-dark">{{ $value->present }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">เบอร์โทร: </strong><span class="text-dark">{{ $value->phone }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">อีเมล: </strong><span class="text-dark">{{ $value->email }}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สังกัด/หน่วยงาน: </strong><span class="text-dark">{{ $value->institution }}</span>
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
                <button type="button" class="btn btn-green rounded-0 text-white">บันทึกและปิด</button>
            </div>
        </div>
    </div>
</div>
@endsection