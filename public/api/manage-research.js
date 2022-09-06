"use strict";

function detail_modal(topic_id) {
    let createModal = `
            <div class="modal fade" id="research_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="รายละเอียด" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดทั้งหมด</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0"
                                data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>`;
    $.ajax({
        method: "GET",
        url: "/show-research-detail/" + topic_id,
        success: function (res) {
            res.forEach((data) => {
                $("#modal_body").html(`
                <div class="mb-3">
                    <strong class="text-green">รหัสบทความ: </strong><span
                        class="text-dark">${data.topic_id}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สถานะบทความ: </strong><span
                        class="text-dark">${data.topic_status}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาไทย: </strong><span
                        class="text-dark">${data.topic_th}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อบทความภาษาอังกฤษ: </strong><span
                        class="text-dark">${data.topic_en}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชื่อผู้นำเสนอบทความ: </strong><span
                        class="text-dark">${data.presenter.replace(
                            "|",
                            ", "
                        )}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">กลุ่มบทความ: </strong><span
                        class="text-dark">${data.faculty}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สาขาย่อย: </strong><span
                        class="text-dark">${data.branch}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ชนิดบทความ: </strong><span
                        class="text-dark">${data.degree}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">รูปแบบการนำเสนอ: </strong><span
                        class="text-dark">${data.present}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">เบอร์โทร: </strong><span
                        class="text-dark">${data.phone}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">อีเมล: </strong><span
                        class="text-dark">${data.email}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">สังกัด/หน่วยงาน: </strong><span
                        class="text-dark">${data.institution}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">ที่อยู่: </strong><span
                        class="text-dark">${data.address}</span>
                </div>
                <div class="mb-3">
                    <strong class="text-green">โควต้าเจ้าภาพร่วม: </strong><span
                        class="text-dark">
                        ${data.kota ? data.kota : "-"}
                    </span>
                </div>
                `);
            });
        },
        beforeSend: function () {
            $("#modal").html(createModal);
            $("#modal_body").html(
                `<div class="text-center">กำลังโหลดข้อมูล กรุณารอสักครู่</div>`
            );
            $("#research_modal").modal("show");
        },
        error: function (event, request, settings) {
            if (!navigator.onLine) {
                $("#modal_body").html(
                    `<div class="text-center">ไม่มีการเชื่อมต่ออินเตอร์เน็ต กรุณาตรวจสอบเครือข่ายของท่าน</div>`
                );
            } else if (!navigator.doNotTrack) {
                $("#modal_body").html(
                    `<div class="text-center">เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้งในภายหลัง</div>`
                );
            }
        },
    });
}

function update_modal(topic_id, title, status_value, text_status) {
    const createModal = `
    <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="เปลี่ยนสถานะ" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status_value" id="status_value" value="${status_value}">
                    ต้องการเปลี่ยนสถานะเป็น <strong id="text_status" class="text-red">${text_status}</strong> ใช่หรือไม่ ?
                </div>
                <div class="modal-footer">
                    <button onclick="thisDisabled(this)" type="button" class="btn btn-success rounded-0 text-white" onclick="update_status(${topic_id}, ${status_value})">ตกลง</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function send_comment_modal(topic_id, type) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    const error = $("#error_file_comment").val();

    const createModal = `
    <form enctype="multipart/form-data" method="POST" action="/backend/researchs/comment-file-upload/${topic_id}">
        <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="อัพโหลดไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            <input type="hidden" name="_method" value="PUT" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <input class="form-control ${
                        error ? `is-invalid` : ``
                    }" type="file" name="file_comment[]" accept=".pdf" multiple>
                    ${
                        error
                            ? `<span class="invalid-feedback" role="alert">
                                    <strong>${error}</strong>
                                </span>`
                            : ``
                    }
                    </div>
                    <div class="modal-footer">
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-success text-white rounded-0">อัพโหลดไฟล์</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function open_modal(e, type) {
    try {
        const topic_id = e.nextElementSibling.value;
        const title = "เปลี่ยนสถานะ";
        const status_value = e.value;
        const text_status =
            type == "change_status" ? e[e.selectedIndex].text : null;
        check_type(type, topic_id, title, status_value, text_status);
    } catch (error) {
        throw error;
    }
}

function check_type(type, topic_id, title, status_value, text_status) {
    switch (type) {
        case "change_status":
            update_modal(topic_id, title, status_value, text_status);
            break;
        case "detail":
            detail_modal(topic_id);
            break;
        case "file":
            send_comment_modal(topic_id, type);
            break;
        default:
            break;
    }
}

function update_status(topic_id, status) {
    try {
        const _token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method: "PUT",
            url: "/update-status/" + topic_id,
            data: {
                topic_status: status,
                _token,
            },
            success: function (data) {
                if (data.success) {
                    window.location.replace("/backend/researchs/management");
                }
            },
            beforeSend: function () {
                console.log("กำลังโหลด");
            },
            error: function (error) {
                if (!navigator.onLine) {
                    console.log(
                        "ไม่มีการเชื่อมต่ออินเตอร์เน็ต กรุณาตรวจสอบเครือข่ายของท่าน"
                    );
                } else if (!navigator.doNotTrack) {
                    console.log(
                        "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้งในภายหลัง"
                    );
                }
            },
        });
    } catch (error) {
        throw error;
    }
}
