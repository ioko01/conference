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
                        class="text-dark">${data.presenter.replaceAll(
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
                    <strong class="text-green">ที่อยู่ในการออกใบเสร็จรับเงิน: </strong><span
                        class="text-dark">${
                            data.address ? data.address : "-"
                        }</span>
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
                    <button type="button" class="btn btn-success rounded-0 text-white" onclick="update_status(${topic_id}, ${status_value});thisDisabled(this);">ตกลง</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function update_modal_passed(topic_id, title, status_value, text_status, type) {
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
                    <button type="button" class="btn btn-success rounded-0 text-white" onclick="update_status_passed(${topic_id}, ${status_value}, '${type}');thisDisabled(this);">ตกลง</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function default_comment_form(topic_id) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    $("#form_modal_confirm").html(`
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
                        <div id="modal_body" class="modal-body"></div>
                        <div id="modal_footer" class="modal-footer">
                            <button onclick="thisDisabled(this)" type="submit" class="btn btn-success text-white rounded-0">อัพโหลดไฟล์</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    `);
    $("#research_modal").modal("show");
}

function confirm_delete(topic_id, filename, file_id) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    $("#form_modal_confirm").html(`
    <form enctype="multipart/form-data" method="POST" action="/backend/researchs/comment-file-delete/${file_id}">
        <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="อัพโหลดไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            <input type="hidden" name="_method" value="DELETE" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">อัพโหลดไฟล์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal_body" class="modal-body">
                        ต้องการลบไฟล์ <strong class="text-red">"${filename}"</strong> หรือไม่ ?
                    </div>
                    <div id="modal_footer" class="modal-footer">
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-success text-white rounded-0">ตกลง</button>
                        <button onclick="send_comment_modal('${topic_id}')" data-bs-dismiss="modal" type="button" class="btn btn-secondary text-white rounded-0">ย้อนกลับ</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    `);
    $("#research_modal").modal("show");
}

function send_comment_modal(topic_id) {
    try {
        const _token = $('meta[name="csrf-token"]').attr("content");
        const error = $("#error_file_comment").val();
        let fileList = "";
        let createModal = `
                <div id="form_modal_confirm">
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
                                    <div id="modal_body" class="modal-body"></div>
                                    <div id="modal_footer" class="modal-footer">
                                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-success text-white rounded-0">อัพโหลดไฟล์</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                    `;

        $.ajax({
            method: "GET",
            url: "/backend/researchs/get-comment-file/" + topic_id,
            success: function (data) {
                data.map((res) => {
                    fileList += `<li class="d-flex justify-content-between mt-1">
                                    <div>
                                        <strong class="mr-2"> - ${
                                            res.comment_name
                                        } ${
                        res.comment_status == "pass"
                            ? `<i class="fas fa-check text-green"></i>`
                            : res.comment_status == "notpass" &&
                              `<i class="fas fa-times text-red"></i>`
                    }</strong> 
                                    </div>
                                    <div>
                                    <button data-bs-dismiss="modal" onclick="confirm_delete('${topic_id}','${
                        res.comment_name
                    }', ${
                        res.comment_id
                    })" class="btn btn-sm rounded-0 btn-danger text-white">
                                        ลบไฟล์
                                    </button>
                                 </li>`;
                });
                $("#modal_body").html(`
                    <input class="form-control ${
                        error ? `is-invalid` : ``
                    }" type="file" name="file_comment" accept=".pdf,.doc,.docx">
                    ${
                        error
                            ? `<span class="invalid-feedback" role="alert">
                                    <strong>${error}</strong>
                                </span>`
                            : ``
                    }
                    <div class="mt-2">
                        <div class="form-check">
                            <input class="form-check-input" id="inp_file_comment_pass" type="radio" name="inp_file_comment" value="pass" checked>
                            <label class="form-check-label" for="inp_file_comment_pass">
                                ผ่านการประเมิน
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="inp_file_comment_notpass" type="radio" name="inp_file_comment" value="notpass">
                            <label class="form-check-label" for="inp_file_comment_notpass">
                                ไม่ผ่านการประเมิน
                            </label>
                        </div>
                    </div>
                    <br/>
                    <strong>รายการไฟล์ที่อัพโหลด</strong>
                    <br/>
                    <i class="fas fa-check text-green"></i> ผ่านการประเมิน &emsp;
                    <i class="fas fa-times text-red"></i> ไม่ผ่านการประเมิน
                    <div class="p-3 mt-3 border">
                        ${fileList}
                    </div>
                    </div>
                `);
            },
            beforeSend: function () {
                $("#modal").html(createModal);
                $("#modal_body").html(
                    `<div class="text-center">กำลังโหลดข้อมูล กรุณารอสักครู่</div>`
                );
                $("#research_modal").modal("hide");
                $("#research_modal").modal("show");
            },
            error: function (error) {
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
    } catch (error) {
        throw error;
    }
}

function add_suggestion_modal(topic_id) {
    const createModal = `
    <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="เพิ่มข้อเสนอแนะ" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">เพิ่มข้อเสนอแนะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editor_${topic_id}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success rounded-0 text-white" onclick="update_suggestion(${topic_id})">เพิ่ม/แก้ไข ข้อเสนอแนะ</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    `;

    $.ajax({
        method: "GET",
        url: "/backend/researchs/get-suggestion/" + topic_id,
        success: function (data) {
            $(`#editor_${topic_id}`).html(data.research_suggestion);

            const toolbarOptions = [
                [
                    "bold",
                    "italic",
                    "underline",
                    { align: "" },
                    { align: "center" },
                    { align: "right" },
                    { align: "justify" },
                    { list: "ordered" },
                    { list: "bullet" },
                ],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ script: "sub" }, { script: "super" }],
                ["link", "image"],
                [{ size: ["small", false, "large", "huge"] }],
                [{ color: [] }, { background: [] }],
            ];

            new Quill(`#editor_${topic_id}`, {
                theme: "snow",
                modules: {
                    toolbar: toolbarOptions,
                },
            });
        },
        beforeSend: function () {
            console.log("กำลังโหลด");
            let op_modal = false;
            $("#modal").on("show.bs.modal", function () {
                if (!op_modal) {
                    op_modal = true;
                    $(`#editor_${topic_id}`).html("กำลังโหลด");
                }
            });
            $("#modal").html(createModal);
            $("#research_modal").modal("show");
        },
    });
}

//เปลี่ยนสถานะบทความ
function update_status_research(topic_id) {
    const createModal = `
    <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="เพิ่มข้อเสนอแนะ" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">เพิ่มข้อเสนอแนะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editor_${topic_id}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success rounded-0 text-white" onclick="update_suggestion(${topic_id})">เพิ่ม/แก้ไข ข้อเสนอแนะ</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    `;

    $.ajax({
        method: "GET",
        url: "/backend/researchs/get-suggestion/" + topic_id,
        success: function (data) {
            $(`#editor_${topic_id}`).html(data.research_suggestion);

            const toolbarOptions = [
                [
                    "bold",
                    "italic",
                    "underline",
                    { align: "" },
                    { align: "center" },
                    { align: "right" },
                    { align: "justify" },
                    { list: "ordered" },
                    { list: "bullet" },
                ],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ script: "sub" }, { script: "super" }],
                ["link", "image"],
                [{ size: ["small", false, "large", "huge"] }],
                [{ color: [] }, { background: [] }],
            ];

            new Quill(`#editor_${topic_id}`, {
                theme: "snow",
                modules: {
                    toolbar: toolbarOptions,
                },
            });
        },
        beforeSend: function () {
            console.log("กำลังโหลด");
            let op_modal = false;
            $("#modal").on("show.bs.modal", function () {
                if (!op_modal) {
                    op_modal = true;
                    $(`#editor_${topic_id}`).html("กำลังโหลด");
                }
            });
            $("#modal").html(createModal);
            $("#research_modal").modal("show");
        },
    });
}

function pass_notpass_file_comment(topic_id, handleData) {
    try {
        $.ajax({
            method: "GET",
            url: "/backend/researchs/get-comment-file/" + topic_id,
            success: function (data) {
                handleData(data);
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

function open_modal(e, type) {
    try {
        const topic_id = e.nextElementSibling.value;
        const title = "เปลี่ยนสถานะ";
        const status_value = e.value;
        const text_status =
            type == "change_status" ||
            type == "change_research_passed" ||
            type == "change_research_passed_1"
                ? e[e.selectedIndex].text
                : null;
        $("#modal").on("hidden.bs.modal", function () {
            for (let i = 0; i < e.length; i++) {
                if (e[i].getAttribute("selected")) {
                    e.value = e[i].value;
                    break;
                }
            }
        });
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
        case "change_research_passed":
            update_modal_passed(
                topic_id,
                title,
                status_value,
                text_status,
                type
            );
            break;
        case "change_research_passed_1":
            update_modal_passed(
                topic_id,
                title,
                status_value,
                text_status,
                type
            );
            break;

        case "add_suggestion":
            add_suggestion_modal(topic_id);
            break;
        default:
            break;
    }
}

function escape(htmlStr) {
    return htmlStr
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}

function manage_index(id, status) {
    $.ajax({
        method: "GET",
        url: "/backend/researchs/management/ajax",
        success: function (res) {
            if (status >= 7) {
                const comments = res.comments;
                let comment_elm = "";
                comments.forEach((element) => {
                    if (id == element.comment_topic_id) {
                        if (element.comment_path) {
                            comment_elm += `<a target="_blank" class="text-info"
                            href="${element.comment_path}"
                            title="คลิกที่นี่เพิ่อดาวน์โหลดไฟล์">
            
                            &bull; <i style="font-size: 10px;" class="fst-normal"
                                class="mb-0">${element.comment_name}
                                ${
                                    element.comment_status == "pass"
                                        ? '&nbsp;<i class="fas fa-check text-green"></i>'
                                        : '&nbsp;<i class="fas fa-times text-red"></i>'
                                }
                            </i><br />
                        </a>
                        <div style="border-bottom: 1px dotted #ccc;" class="my-2">
            
                        </div>`;
                        }
                    }
                });

                $(`#${id}`).html(`
                    <div class="text-start">
                        <button type="button" class="btn btn-sm btn-info rounded-0 text-white w-100 mb-3" onclick="open_modal(this, 'file')">
                            <i class="fas fa-upload"></i> อัพโหลด / ลบไฟล์
                        </button>
                        <input type="hidden" value="${id}">

                        <input type="hidden" name="error_file_comment" id="error_file_comment">
                        ${comment_elm}
                    </div>
                `);
            } else {
                $(`#${id}`).html("-");
            }
            if (status >= 5) {
                $(`#sug_${id}`).html(`
                    <table class="w-100">
                        <tbody>
                            <tr id="tbl_${id}">
                            </tr>
                        </tbody>
                    </table>
                `);

                if (status >= 5) {
                    let tbl_elm = "";
                    for (let i = 0; i < 3; i++) {
                        const suggestion = res.suggestion;
                        let suggestion_elm = "";
                        suggestion.forEach((element) => {
                            if (
                                id == element.topic_id &&
                                element.number == i + 1
                            ) {
                                const path = element.path;
                                suggestion_elm += `
                                <a class="text-info d-block" href="${path}" download>
                                &bull; <i style="font-size: 10px;" class="fst-normal">${element.name}</i></a>
                                    <div style="border-bottom: 1px dotted #ccc;" class="my-2"> </div>
                                `;
                            }
                        });

                        get_topic_id(id, (res) => {
                            const data = {
                                topic_id: String(id),
                                topic_th: res.topic_th,
                                topic_en: res.topic_en,
                                link:
                                    window.location.host +
                                    `/suggestion/${btoa(
                                        String(
                                            `${i + 1}|${id}|${String(
                                                res.created_at
                                            )}`
                                        )
                                    )}`,
                            };
                            const json = JSON.stringify(data);
                            tbl_elm += `
                            <td class="p-0 px-2" style="border-top: 0px solid transparent;width: 33%;">
                            <button style="min-width: 100px;" class="btn rounded-0 btn-sm btn-outline-success w-100 mb-3" onclick="open_modal_default('#modal', 'xl', 'ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ', '${escape(
                                json
                            )}')">
                                <i class="fas fa-link"></i> ลิงค์</button>
                                <br />
                                ${suggestion_elm}
                            </td>`;
                            if (i == 2) {
                                $(`#tbl_${id}`).html(``);
                                $(`#tbl_${id}`).append(tbl_elm);
                            } else {
                                $(`#tbl_${id}`).html(`<td style="border-top: 0px solid transparent;" colspan="3">-</td>`);
                            }
                        });
                    }
                } else {
                    $(`#tbl_${id}`).append(
                        `<td style="border-top: 0px solid transparent;" colspan="3"> - </td>`
                    );
                }
            } else {
                $(`#sug_${id}`).html("-");
            }
        },
    });
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
                    $(`#select_${topic_id} option`).removeAttr("selected");
                    $(`#select_${topic_id} option:selected`).attr(
                        "selected",
                        "selected"
                    );
                    Swal.fire({
                        title: "สำเร็จ",
                        html: `เปลี่ยนสถานะบทความสำเร็จ`,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });

                    $("#research_modal").modal("dispose");
                    $("#research_modal").remove();
                } else {
                    Swal.fire({
                        title: "ผิดพลาด",
                        html: `ไม่สามารถเปลี่ยนสถานะบทความได้`,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
                manage_index(topic_id, status);
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

function update_status_passed(topic_id, status, type) {
    try {
        let url = "";
        if (type == "change_research_passed_1") {
            url = "/backend/research/passed/1/update-status/" + topic_id;
        } else if (type == "change_research_passed") {
            url = "/backend/research/passed/update-status/" + topic_id;
        }

        let delta = $(`#editor_${topic_id} .ql-editor`).html();
        if (delta) {
            const regex = /(<([^>]+)>)/gi;
            const hasText = delta.replaceAll(regex, "").trim().length;
            if (hasText == 0) {
                delta = "";
            }
        }

        const _token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method: "PUT",
            url: url,
            data: {
                research_passed: status,
                _token,
            },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        title: "สำเร็จ",
                        html: `เปลี่ยนสถานะข้อเสนอแนะสำเร็จ`,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                    $("#research_modal").modal("dispose");
                    $("#research_modal").remove();

                    if (status == 2) {
                        $(`#suggestion_container_${topic_id}`).html(
                            `<div id="btn_suggestion_${topic_id}">
                            <button class="btn btn-info rounded-0 mt-3 text-sm"
                                onclick="open_modal(this, 'add_suggestion')">
                                + เพิ่ม/แก้ไข ข้อเสนอแนะ
                            </button>
                            <input type="hidden" value="${topic_id}">
                        </div>`
                        );

                        if (delta) {
                            $(`#suggestion_container_${topic_id}`).append(
                                `<div id="suggestion_${topic_id}">
                                <span class="text-green text-sm">
                                    <i class="fas fa-check text-green"></i>&nbsp;มีข้อเสนอแนะแล้ว
                                </span>
                            </div>`
                            );
                        } else {
                            $(`#suggestion_container_${topic_id}`).append(
                                `<div id="suggestion_${topic_id}">
                                <span class="text-red text-sm">
                                    <i class="fas fa-times text-red"></i>&nbsp;ไม่มีข้อเสนอแนะ
                                </span>
                            </div>`
                            );
                        }
                    } else {
                        $(`#suggestion_container_${topic_id}`).html(``);
                    }
                } else {
                    Swal.fire({
                        title: "ผิดพลาด",
                        html: `ไม่สามารถเปลี่ยนสถานะข้อเสนอแนะได้`,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            },
            beforeSend: function () {
                console.log("กำลังโหลด");
            },
            error: function (error) {
                console.log(error);
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

//เพิ่มข้อเสนอแนะ
function update_suggestion(topic_id) {
    try {
        const _token = $('meta[name="csrf-token"]').attr("content");

        let delta = $(`#editor_${topic_id} .ql-editor`).html();
        if (delta) {
            const regex = /(<([^>]+)>)/gi;
            const hasText = delta.replaceAll(regex, "").trim().length;
            if (hasText == 0) {
                delta = "";
            }
        }

        $.ajax({
            method: "PUT",
            url: "/backend/research/suggestion/update/" + topic_id,
            data: {
                research_suggestion: delta,
                _token,
            },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        title: "สำเร็จ",
                        html: `เพิ่มข้อเสนอแนะสำเร็จ`,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                    $("#research_modal").modal("hide");
                } else {
                    $("#editor .ql-editor").html("");
                    Swal.fire({
                        title: "ผิดพลาด",
                        html: `ไม่สามารถเพิ่มข้อเสนอแนะได้`,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }

                if (delta != "") {
                    $(`#suggestion_${topic_id}`).html(
                        `<span class="text-green text-sm">
                            <i class="fas fa-check text-green"></i>&nbsp;มีข้อเสนอแนะแล้ว
                        </span>`
                    );
                } else {
                    $(`#suggestion_${topic_id}`).html(
                        `<span class="text-red text-sm">
                           <i class="fas fa-times text-red"></i>&nbsp;ไม่มีข้อเสนอแนะ
                        </span>`
                    );
                }
            },
            beforeSend: function () {
                Swal.fire({
                    title: "",
                    html: `<div class="lds-ring my-3"><div></div><div></div><div></div><div></div></div>`,
                    showCancelButton: false,
                    showConfirmButton: false,
                });
            },
            error: function (error) {
                $("#editor .ql-editor").html("");
                console.log(error);
                if (!navigator.onLine) {
                    Swal.fire(
                        "ผิดพลาด",
                        "ไม่มีการเชื่อมต่ออินเตอร์เน็ต กรุณาตรวจสอบเครือข่ายของท่าน",
                        "error"
                    );
                    console.log(
                        "ไม่มีการเชื่อมต่ออินเตอร์เน็ต กรุณาตรวจสอบเครือข่ายของท่าน"
                    );
                } else if (!navigator.doNotTrack) {
                    Swal.fire(
                        "ผิดพลาด",
                        "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้งในภายหลัง",
                        "error"
                    );
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
