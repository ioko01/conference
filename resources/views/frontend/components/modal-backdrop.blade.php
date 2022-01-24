@section('modal')
    <!-- Modal PAYMENT -->
    <form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.store') }}"
        class="modal fade" id="payment-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="ชำระเงิน" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ชำระเงิน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="payment-upload" id="payment-upload" accept=".jpg, .jpeg">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal WORD -->
    <form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.store') }}"
        class="modal fade" id="word-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="อัพโหลดไฟล์ WORD" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ WORD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="word-upload" id="word-upload" accept=".doc, .docx">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal PDF -->
    <form enctype="multipart/form-data" method="POST" action="{{ route('employee.file-upload.store') }}"
        class="modal fade" id="pdf-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="อัพโหลดไฟล์ PDF" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์ PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="pdf-upload" id="pdf-upload" accept=".pdf">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
                </div>
            </div>
        </div>
    </form>




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
