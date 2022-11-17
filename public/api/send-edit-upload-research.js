"use strict";

function detail_modal(topic_id, type) {
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

    const route = "/show-research-detail/" + topic_id;
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": token,
        },
    });
    $.ajax({
        type: "GET",
        url: route,
        statusCode: {
            401: function () {
                $("#modal_body").html(
                    `<div class="text-center">ไม่ได้รับสิทธิ์ในการเข้าถึงหน้านี้</div>`
                );
            },
        },
        success: function (res) {
            res.forEach((data) => {
                $("#modal_body").html(`
                <div class="text-end">
                    <a href="/employee/research/edit/${topic_id}"
                        class="text-warning">
                        <i class="fas fa-edit"></i> แก้ไขรายละเอียด</a>
                </div>
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
                $("#modal_body").html(event.responseText);
            }
        },
    });
}

function send_edit_research_modal(topic_id, type, method) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    const iType = ["word", "pdf", "stm", "word_2", "pdf_2", "stm_2"];
    const createModal = `
    <form enctype="multipart/form-data" method="POST" action="/employee/research/send-edit/${
        iType.filter((item) => item === type) ? type : ""
    }/${topic_id}/${method ? `update` : `store`}">
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
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-green text-white rounded-0">อัพโหลดไฟล์</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function send_research_modal(topic_id, type, method) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    const createModal = `
    <form enctype="multipart/form-data" method="POST" action="/employee/${
        type == "send_word" ? "word" : "pdf"
    }/${topic_id}/${method ? `upload` : `store`}">
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
                        type == "send_word"
                            ? `<input class="form-control"
                                type="file"
                                name="word_upload"
                                accept=".doc, .docx"
                            />`
                            : type == "send_pdf"
                            ? `<input class="form-control" type="file" name="pdf_upload" accept=".pdf" />`
                            : `<input class="form-control" type="file" name="stm_upload" accept=".pdf" />`
                    }
                    </div>
                    <div class="modal-footer">
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-green text-white rounded-0">อัพโหลดไฟล์</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function payment_modal(topic_id, type, path, method) {
    const error_payment = $("#error_payment").val();
    const error_date = $("#error_date").val();
    const error_address = $("#error_address").val();

    const _token = $('meta[name="csrf-token"]').attr("content");
    const createModal = `
    <form enctype="multipart/form-data" method="POST" ${
        path
            ? `action="/employee/payment/${topic_id}/upload"`
            : `action="/employee/payment/${topic_id}/store"`
    } class="modal fade"
        id="payment_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="ชำระเงิน"
        aria-hidden="true">
        <input type="hidden" name="_token" value="${_token}" />
        ${method ? `<input type="hidden" name="_method" value="PUT" />` : ""}

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ชำระเงิน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h2>รูปแบบการชำระเงิน</h2>
                        <p class="text-green">
                            <strong>ชำระค่าลงทะเบียนผ่านธนาคาร เข้าบัญชีออมทรัพย์ชื่อบัญชี
                                <span class="text-bluesky">“วารสารวิจัยและพัฒนา ม.ราชภัฏเลย”เลขที่บัญชี 981-2-85863-6 ธนาคารกรุงไทย
                                    สาขาเลย</span>
                            </strong>
                        </p>

                        <p class="text-dark">
                            <strong>
                                1. ผู้นำเสนอจากหน่วยงานภายนอก
                            </strong> ที่ส่งผลงาน ค่าลงทะเบียนอัตรา 2,000 บาท ต่อ 1 ผลงาน<br />
                            <strong>
                                2. ผู้ร่วมงานทั่วไป/นิสิต/นักศึกษาจากหน่วยงานภายนอก
                            </strong> ไม่เสียค่าใช้จ่าย
                            <br />
                            <strong>
                                3. บุคลากรภายในมหาวิทยาลัยราชภัฏเลย
                            </strong> ไม่เสียค่าใช้จ่าย
                            <br /> 4.
                            ข้าราชการหรือบุคลากรของรัฐที่เข้าร่วมประชุมสามารถเบิกจ่ายได้จากต้นสังกัดตามระเบียบของกระทรวงการคลัง
                        </p>

                        <p class="text-red">
                            <strong>
                                * หมายเหตุ: กรณีที่ผู้สมัครเข้าร่วมงานและไม่สามารถมานำเสนอผลงานได้ สถาบันวิจัยและพัฒนา ขอสงวนสิทธิ์
                                ที่จะไม่คืนเงินค่าลงทะเบียนไม่ว่ากรณีใดๆ เนื่องจากต้องมีค่าใช้จ่ายในระหว่างการดำเนินงาน
                            </strong>
                        </p>
                    </div>
                    <hr/>
                    <div class="mb-3">
                    <label for="payment_upload">อัพโหลดสลิปชำระเงิน</label>
                        <input type="file" class="form-control ${
                            error_payment ? `is-invalid` : ``
                        }"
                            name="payment_upload" id="payment_upload" accept=".jpg, .jpeg" onchange="image(this)">
                        ${
                            error_payment
                                ? `<span class="invalid-feedback" role="alert">
                        <strong>${error_payment}</strong>
                    </span>`
                                : ``
                        }
                    </div>

                    <div class="mb-3">
                        <label for="date">วันที่ชำระเงิน</label>
                        <input type="date" name="date" id="date" class="form-control ${
                            error_date ? `is-invalid` : ``
                        }">
                        ${
                            error_date
                                ? `<span class="invalid-feedback" role="alert">
                        <strong>${error_date}</strong>
                    </span>`
                                : ``
                        }
                    </div>

                    <div class="mb-3">
                        <label for="address">ที่อยู่ผู้ชำระเงิน</label>
                        <textarea class="form-control ${
                            error_address ? `is-invalid` : ``
                        }" name="address" id="address" cols="30" rows="10"></textarea>
                        ${
                            error_address
                                ? `<span class="invalid-feedback" role="alert">
                        <strong>${error_address}</strong>
                    </span>`
                                : ``
                        }
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="thisDisabled(this)" formnovalidate="formnovalidate" type="submit" class="btn btn-green rounded-0 text-white">อัพโหลด</button>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#payment_modal").modal("show");
}

function payment_modal_example(path) {
    const createModal = `
    <div class="modal fade" id="payment_modal_example" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="ตัวอย่างการชำระเงิน" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">สลิปการชำระเงิน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img width="100%" src="${path}" alt="SLIP" title="SLIP">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0 text-white"
                        data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    `;
    $("#modal").html(createModal);
    $("#payment_modal_example").modal("show");
}

function open_modal(e, type, method = null, path = null) {
    try {
        const topic_id = e.nextElementSibling.value;
        check_type(type, topic_id, path, method);
    } catch (error) {
        throw error;
    }
}

function check_type(type, topic_id, path, method) {
    switch (type) {
        case "detail":
            detail_modal(topic_id, type);
            break;
        case "payment":
            payment_modal(topic_id, type, path, method);
            break;
        case "payment_example":
            payment_modal_example(path);
            break;
        case "word":
            send_edit_research_modal(topic_id, type, method);
            break;
        case "send_word":
            send_research_modal(topic_id, type, method);
            break;
        case "send_pdf":
            send_research_modal(topic_id, type, method);
            break;
        case "pdf":
            send_edit_research_modal(topic_id, type, method);
            break;
        case "stm":
            send_edit_research_modal(topic_id, type, method);
            break;
        case "word_2":
            send_edit_research_modal(topic_id, type, method);
            break;
        case "pdf_2":
            send_edit_research_modal(topic_id, type, method);
            break;
        case "stm_2":
            send_edit_research_modal(topic_id, type, method);
            break;
        default:
            break;
    }
}
