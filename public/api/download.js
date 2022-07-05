"use strict";

const get_video = (id) => {
    return $.ajax({
        method: "GET",
        url: `/api/get-${type}/${topic_id}`,
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

const openModal = (id) => {
    let title = "";
    let content = "";
    const _token = $('meta[name="csrf-token"]').attr("content");
    $.when(get_video(id)).done(function (res) {
        console.log(res);
    });
    if (type == "video") {
        title = "เพิ่มลิงค์วิดีโอ";
        content = `
        <label for="video">ใส่ลิงค์วิดีโอ <i class="text-red">(ตัวอย่าง เช่น: https://www.youtube.com)</i></label>
        <input id="video" type="text" name="video" class="form-control" placeholder="ใส่ลิงค์วิดีโอ">
        `;
    } else if (type == "poster") {
        title = "อัพโหลดไฟล์โปสเตอร์";
        content = `
        <label for="poster">อัพโหลดไฟล์โปสเตอร์ <i style="font-size: 12px;" class="text-red"><br/>* นามสกุลไฟล์ต้องเป็น .jpg, .jpeg<br/>* ขนาดไฟล์ต้องไม่เกิน 10 MB</i></label>
        <input id="poster" type="file" name="poster" class="form-control" placeholder="อัพโหลดไฟล์โปสเตอร์" accept=".jpg, .jpeg">
        `;
    }
    let createModal = `
            <div class="modal fade" id="video_poster_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="เพิ่มวิดีโอและโปสเตอร์" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="/employee/research/uploadfile/${topic_id}/create" method="POST">
                            <input type="hidden" name="_token" value="${_token}" />
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">${title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modal_body">${content}</div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success rounded-0">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-danger rounded-0"
                                    data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>`;

    $("#modal").html(createModal);
    $("#video_poster_modal").modal("show");
};
