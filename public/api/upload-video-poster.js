"use strict";

const openModal = (type, id) => {
    let title = "";
    let content = "";
    if (type == "video") {
        title = "เพิ่มลิงค์วิดีโอ";
        content = `
        <label for="video">ใส่ลิงค์วิดีโอ <i class="text-red">(ตัวอย่าง เช่น: https://www.youtube.com)</i></label>
        <input id="video" type="text" class="form-control" placeholder="ใส่ลิงค์วิดีโอ">
        `;
    } else if (type == "poster") {
        title = "อัพโหลดไฟล์โปสเตอร์";
        content = `
        <label for="poster">อัพโหลดไฟล์โปสเตอร์ <i style="font-size: 12px;" class="text-red"><br/>* นามสกุลไฟล์ต้องเป็น .jpg, .jpeg, .png, .giff<br/>* ขนาดไฟล์ต้องไม่เกิน 10 MB</i></label>
        <input id="poster" type="file" class="form-control" placeholder="อัพโหลดไฟล์โปสเตอร์">
        `;
    }
    let createModal = `
            <div class="modal fade" id="video_poster_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="เพิ่มวิดีโอและโปสเตอร์" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body">
                        ${content}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success rounded-0">
                                <i class="fa fa-save"></i> บันทึก
                            </button>
                            <button type="button" class="btn btn-danger rounded-0"
                                data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>`;

    $("#modal").html(createModal);
    $("#video_poster_modal").modal("show");
};
