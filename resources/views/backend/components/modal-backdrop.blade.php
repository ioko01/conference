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
                        str_replace('|', ', ', $value->presenter) }}</span>
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