@section('modal')
<!-- Modal STATUS -->
@foreach ($data as $value)
<form enctype="multipart/form-data" method="POST" action="{{ route('admin.research.status', $value->topic_id) }}"
    class="modal fade" id="status-update-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="อัพเดตสถานะ" aria-hidden="true">
    @csrf
    @method('PUT')
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">อัพเดตสถานะ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ต้องการเปลี่ยนสถานะเป็น <strong id="text-status" class="text-red"></strong> ใช่หรือไม่ ?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-green rounded-0 text-white">ตกลง</button>
                <button type="button" class="btn btn-danger rounded-0 text-white">ยกเลิก</button>
            </div>
        </div>
    </div>
</form>
@endforeach
@endsection