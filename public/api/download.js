"use strict";

const get_id = (id) => {
    return $.ajax({
        method: "GET",
        url: `/api/get-download/${id}`,
        success: function (res) {
            return res;
        },
        beforeSend: function () {
            console.log(`กำลังโหลดข้อมูล กรุณารอสักครู่`);
        },
        error: function (event, request, settings) {
            if (!navigator.onLine) {
                console.log(
                    `ไม่มีการเชื่อมต่ออินเตอร์เน็ต กรุณาตรวจสอบเครือข่ายของท่าน`
                );
            } else if (!navigator.doNotTrack) {
                console.log(
                    `เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้งในภายหลัง`
                );
            }
        },
    });
};

const open_modal = (id, e) => {
    const _token = $('meta[name="csrf-token"]').attr("content");
    $.when(get_id(id, e)).done(function (res) {
        let createModal = `
            <div class="modal fade" id="video_poster_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="เพิ่มวิดีโอและโปสเตอร์" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="#" method="POST">
                            <input type="hidden" name="_token" value="${_token}" />
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">ลบไฟล์ดาวน์โหลด</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modal_body">
                                <label for="poster">ต้องการลบหัวข้อ <span class="text-danger">"${res.name}"</span> หรือไม่?</label>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger rounded-0">
                                    <i class="fa fa-trash-alt"></i> ลบ
                                </button>
                                <button type="button" class="btn btn-secondary rounded-0"
                                    data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>`;

        $("#modal").html(createModal);
        $("#video_poster_modal").modal("show");
    });
};
