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
        url: "/api/show-research-detail/" + topic_id,
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

function send_research_modal(topic_id, type, method) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    const iType = ["word", "pdf", "stm", "word_2", "pdf_2", "stm_2"];
    const createModal = `
    <form enctype="multipart/form-data" method="POST" action="/employee/research/send-edit/${
        iType.filter((item) => item === type) ? type : ""
    }/${topic_id}/${method ? `update` : `create`}">
        <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="อัพโหลดไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            ${
                method
                    ? `<input type="hidden" name="_method" value="PUT" />`
                    : ""
            }
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    ${
                        type == "word" || type == "word_2"
                            ? `<input class="form-control"
                                type="file"
                                name="word_upload"
                                accept=".doc, .docx"
                            />`
                            : type == "pdf" || type == "pdf_2"
                            ? `<input class="form-control" type="file" name="pdf_upload" accept=".pdf" />`
                            : `<input class="form-control" type="file" name="stm_upload" accept=".pdf" />`
                    }
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-green text-white rounded-0">อัพโหลดไฟล์</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function open_modal(e, type, method = null) {
    try {
        const topic_id = e.nextElementSibling.value;
        check_type(type, topic_id, method);
    } catch (error) {
        throw error;
    }
}

function check_type(type, topic_id, method) {
    switch (type) {
        case "detail":
            detail_modal(topic_id, type);
            break;
        case "word":
            send_research_modal(topic_id, type, method);
            break;
        case "pdf":
            send_research_modal(topic_id, type, method);
            break;
        case "stm":
            send_research_modal(topic_id, type, method);
            break;
        case "word_2":
            send_research_modal(topic_id, type, method);
            break;
        case "pdf_2":
            send_research_modal(topic_id, type, method);
            break;
        case "stm_2":
            send_research_modal(topic_id, type, method);
            break;
        default:
            break;
    }
}
