"use strict";

const open_modal_poster_video = (type, topic_id, video_poster) => {
    get_video(type, topic_id, video_poster);
};

const get_video = (type, topic_id, video_poster) => {
    let title = "";
    let content = "";
    let createModal = "";
    let input_method = "";
    let btn_submit = "";
    let update_ro_create = "";
    const _token = $('meta[name="csrf-token"]').attr("content");
    if (video_poster) {
        if (type == "video") {
            title = "แก้ไขลิงค์วิดีโอ";
            content = `
            <label for="video">ใส่ลิงค์วิดีโอ <i class="text-red">(ตัวอย่าง เช่น: https://www.youtube.com)</i></label>
            <input value="${video_poster}" id="video" type="text" name="video" class="form-control" placeholder="ใส่ลิงค์วิดีโอ">
            `;
        } else if (type == "poster") {
            title = "แก้ไขไฟล์โปสเตอร์";
            content = `
            <label for="poster">แก้ไขไฟล์โปสเตอร์ <i style="font-size: 12px;" class="text-red"><br/>* นามสกุลไฟล์ต้องเป็น .jpg, .jpeg<br/>* ขนาดไฟล์ต้องไม่เกิน 10 MB</i></label>
            <input id="poster" type="file" name="poster" class="form-control" placeholder="อัพโหลดไฟล์โปสเตอร์" accept=".jpg, .jpeg">
            `;
        }
        input_method = `<input type="hidden" name="_method" value="PUT" />`;
        btn_submit = `<button type="submit" class="btn btn-warning text-white rounded-0">
                        <i class="fa fa-edit"></i> แก้ไข
                    </button>`;
        update_ro_create = "update";
    } else {
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
        btn_submit = `<button type="submit" class="btn btn-success rounded-0">
                        <i class="fa fa-save"></i> บันทึก
                    </button>`;
        update_ro_create = "create";
    }
    createModal = `
        <div class="modal fade" id="video_poster_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="เพิ่มวิดีโอและโปสเตอร์" aria-hidden="true">
            <div class="modal-dialog">
                <form enctype="multipart/form-data" action="/employee/research/uploadfile/${topic_id}/${update_ro_create}" method="POST">
                    <input type="hidden" name="_token" value="${_token}" />
                    ${input_method}
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
                            ${btn_submit}
                            <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `;

    $("#modal").html(createModal);
    $("#video_poster_modal").modal("show");
};
