"use strict";

const delay = (() => {
    let timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

let get_data = "";

function add_expert_list(topic_id, receive) {
    $.ajax({
        method: "GET",
        url: `/backend/get-expert-user-with-id/${receive}/${topic_id}`,
        success: function (res) {
            const data = res[0];
            if (data) {
                Swal.fire({
                    title: "ผิดพลาด",
                    html: `มีรายชื่อนี้แล้ว`,
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                });
            } else {
                const data = new FormData();
                const _token = $('meta[name="csrf-token"]').attr("content");

                data.append("topic_id", topic_id);
                data.append("expert_receive_id", receive);
                data.append("_token", _token);

                $.ajax({
                    method: "POST",
                    url: `/backend/add-file-expert`,
                    cache: false,
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Swal.fire({
                            title: "สำเร็จ",
                            html: `เพิ่มรายชื่อสำเร็จ`,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        });
                        get_expert_list(res[0].topic_id);
                    },
                    beforeSend: function () {},
                });
            }
        },
    });
}

function add_expert(topic_id) {
    const id = $("#name_expert_hidden").val();

    $.ajax({
        method: "GET",
        url: `/backend/get-expert/${id}`,
        success: function (res) {
            const data = res[0];
            $("#add_expert_user").html("ค้นหาผู้ทรงคุณวุฒิ");
            if (data) {
                $("#expert-list-search").html(`
                <div style="border: 1px solid #b8d8be;background-color: #e0f0e3;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                    <div class="w-100">
                        <p>
                        <strong class="text-warning">${
                            data.person_attend == "expert"
                                ? "ตำแหน่ง: ผู้ทรงคุณวุฒิ"
                                : "ตำแหน่ง: -"
                        }</strong>
                        </p>
                        <p><strong>ชื่อ: ${data.prefix}${
                    data.fullname
                }</strong></p>
                        <p><strong>สังกัด/หน่วยงาน: ${
                            data.institution ? data.institution : "-"
                        }</strong></p>
                        <p><strong>อีเมล: <a href="mailto:${data.email}">${
                    data.email
                }</a></strong></p>
                        <p><strong>เบอร์โทร: ${
                            data.phone ? data.phone : "-"
                        }</strong></p>
                        <button onclick="add_expert_list('${topic_id}', '${id}')" class="btn btn-success rounded-0">เพิ่มผู้ทรงคุณวุฒิ</button>
                    </div>
                </div>
                `);
            } else {
                $("#expert-list-search").html(`
                <div style="border: 1px solid #ee6969;background-color:#fde0e0;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                    ไม่มีรายชื่อนี้
                </div>
                `);
            }
        },
        beforeSend: function () {
            $("#add_expert_user").html("กำลังโหลด");
            $("#expert-list-search").html(`
            <div style="border: 1px solid #ffd400;background-color:#ffffb7;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                กำลังโหลด
            </div>
                `);
        },
        error: function (err) {
            if (err.statusText == "Not Found") {
                // console.log("ไม่มีผู้ทรงชื่อนี้");
                $("#expert-list-search").html(`
                <div style="border: 1px solid #ee6969;background-color:#fde0e0;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                    ไม่มีรายชื่อนี้
                </div>
                `);
            }
            $("#add_expert_user").html("ค้นหาผู้ทรงคุณวุฒิ");
        },
    });
}

function add_file(topic_id, receive) {
    const data = new FormData();
    const _token = $('meta[name="csrf-token"]').attr("content");
    const send_file = $(`#expert_${receive} .send_file`)[0].files[0];
    data.append("topic_id", topic_id);
    data.append("admin_send_file", send_file);
    data.append("expert_receive_id", receive);
    data.append("_token", _token);

    $.ajax({
        method: "POST",
        url: `/backend/add-file-expert`,
        cache: false,
        data: data,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res) {
                Swal.fire({
                    title: "สำเร็จ",
                    html: `ส่งบทความให้ผู้ทรงอ่านแล้ว`,
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                });

                $(`#expert_${receive} .list_admin_send_file`).append(`
                    <li style="border: 1px solid #A8B5E0;background-color: #DAF0F7;" class="d-flex justify-content-between align-items-center px-2 my-2">
                        <a href="/${res[0].path_admin_send}">${res[0].file_admin_send}</a> 
                        <button class="btn btn-link text-danger fw-bold rounded-0 p-1 m-1" data-bs-dismiss="modal" onclick="confirm_delete_suggestion('${topic_id}','${res[0].file_admin_send}', ${res[1]})">ลบไฟล์</button>
                    </li>
                `);

                $(`#expert_${receive} .send_file`).val("");
                $(`#delete_list_expert_${receive} button`).remove();
            }
        },
        error: function (err) {},
        beforeSend: function () {
            $(this).val("กำลังโหลด");
        },
    });
}

function filter_data_input(e, data = "") {
    $(".search-list").html("");
    delay(function () {
        const value = e.value.trim();
        const data_array = data.split(",");
        const filter = data_array.filter((res) => {
            if (res.split("|")[1].match(value)) {
                $(".search-list").append(
                    `<li class="d-block w-100" value="${
                        res.split("|")[0]
                    }" onclick="set_value(this)">${res.split("|")[1]}</li>`
                );
            } else {
                // $("#name_expert_hidden").val("");
            }

            return res.match(value);
        });

        filter.length > 0
            ? $(".search-list").css("display", "block")
            : $(".search-list").css("display", "none");
    }, 200);
}

function focusout_input() {
    $(".search-list").on("click", function () {
        // $(".search-list").html("");
        $(".search-list").css("display", "none");
    });

    $("#modal_body").on("click", function () {
        // $(".search-list").html("");
        if (!$("#name_expert_input").is(":focus")) {
            $(".search-list").css("display", "none");
        }
    });
}

function set_value(text) {
    $("#name_expert_input").val(text.innerHTML);
    $("#name_expert_hidden").val(text.value);
}

function get_expert_list(topic_id) {
    $.ajax({
        method: "GET",
        url: `/backend/get-expert-user/${topic_id}`,
        success: function (res) {
            $("#expert-list").html("");
            const old_user_id = [];
            let is_file = [];
            if (res) {
                res.map((data) => {
                    let append_admin_send_file = "";
                    let append_expert_receive_file = "";
                    if (!old_user_id.includes(data.user_expert_id)) {
                        old_user_id.push(data.user_expert_id);

                        res.map((file, index) => {
                            // console.log(res);
                            if (!is_file.includes(file.topic_id)) {
                                if (
                                    file.path_admin_send ||
                                    file.path_expert_receive
                                ) {
                                    is_file[index] = file.user_expert_id;
                                }
                            }
                            if (file.file_admin_send) {
                                if (
                                    data.user_expert_id == file.user_expert_id
                                ) {
                                    append_admin_send_file += `<li style="border: 1px solid #A8B5E0;background-color: #DAF0F7;" class="d-flex justify-content-between align-items-center px-2 my-2">
                                    <a href="/${file.path_admin_send}">${file.file_admin_send}</a> 
                                    <button class="btn btn-link text-danger fw-bold rounded-0 p-1 m-1" data-bs-dismiss="modal" onclick="confirm_delete_suggestion('${topic_id}','${file.file_admin_send}', ${file.sug_id})">ลบไฟล์</button>
                                </li>`;
                                }
                            }

                            if (file.file_expert_receive) {
                                if (
                                    data.user_expert_id == file.user_expert_id
                                ) {
                                    append_expert_receive_file += `<li style="border: 1px solid #A8B5E0;background-color: #DAF0F7;" class="d-flex justify-content-between align-items-center p-2 my-2">
                                    <a href="/${file.path_expert_receive}">${file.file_expert_receive}</a></li>`;
                                }
                            }
                        });

                        const filtered = is_file.filter(function (el) {
                            return el != null;
                        });

                        console.log(filtered);

                        $("#expert-list").append(`
                    <div id="expert_${
                        data.user_expert_id
                    }" style="border: 1px solid #A8B5E0;background-color:#DAF0F7;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                        <div class="w-100">
                        <div id="delete_list_expert_${
                            data.user_expert_id
                        }" class="text-end">
                            <p class="text-danger"><strong>**ต้องลบไฟล์ออกให้หมดก่อนถึงจะลบรายชื่อออกได้ และถ้ามีผู้ทรงคุณวุฒิส่งไฟล์มาแล้วจะไม่สามารถลบรายชื่อได้</strong></p>
                            ${
                                !filtered.includes(data.user_expert_id)
                                    ? `<button class="btn btn-danger text-end rounded-0 text-end" data-bs-dismiss="modal" onclick="confirm_delete_expert('${data.fullname}', ${data.user_expert_id}, ${data.sug_id})">ลบรายชื่อ</button>`
                                    : ``
                            }
                            
                        </div>
                            <p>
                            <strong class="text-warning">${
                                data.person_attend == "expert"
                                    ? "ตำแหน่ง: ผู้ทรงคุณวุฒิ"
                                    : "ตำแหน่ง: -"
                            }</strong>
                            </p>
                            <p><strong>ชื่อ: ${data.prefix}${
                            data.fullname
                        }</strong></p>
                            <p><strong>สังกัด/หน่วยงาน: ${
                                data.institution ? data.institution : "-"
                            }</strong></p>
                            <p><strong>อีเมล: <a href="mailto:${data.email}">${
                            data.email
                        }</a></strong></p>
                            <p><strong>เบอร์โทร: ${
                                data.phone ? data.phone : "-"
                            }</strong></p>
                        </div>
                        <div class="d-flex justify-content-center w-100 text-center bg-white border rounded">
                        <div class="w-50 h-100 py-2">
                            <strong>ไฟล์ที่ผู้ทรงคุณวุฒิอัพโหลด</strong>
                            <div style="border-bottom:1px solid #dee2e6;" class="py-2"></div>
                            <ul style="overflow: auto;" class="text-start mb-0 p-2 list_expert_send_file">${append_expert_receive_file}</ul>
                        </div>
                        <div style="border: 1px solid #dee2e6;"></div>
                        <div class="w-50 h-100 py-2">
                            <strong>อัพโหลดไฟล์ให้ผู้ทรงคุณวุฒิ</strong>
                            <div style="border-bottom:1px solid #dee2e6;" class="py-2"></div>
                            <div class="p-2 d-flex gap-2">
                                <input class="form-control h-100 send_file" type="file" accept=".pdf"/>
                                <button class="btn btn-success rounded-0 h-100" onclick="add_file('${topic_id}', '${
                            data.user_expert_id
                        }')">อัพโหลด</button>
                            </div>
                            <div style="border-bottom:1px solid #dee2e6;"></div>
                            <ul style="overflow: auto;" class="text-start mb-0 p-2 list_admin_send_file">${append_admin_send_file}</ul>
                        </div>
                        </div>
                    </div>
                    `);
                    }
                });
            }
        },
        beforeSend: function () {
            $("#expert-list").html(`
            <div style="border: 1px solid #A8B5E0;background-color:#DAF0F7;" class="d-flex flex-column p-2 my-4 p-3 rounded justify-content-between">
                <div class="w-100 text-center">
                กำลังโหลดรายชื่อ
                </div>
            </div>
            `);
        },
    });
}

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    if (data) get_data = data;
    const json = JSON.parse(data);
    const list_expert = [];
    json.list_expert.map((res) => {
        list_expert.push(
            `${res.expert_id}|${res.expert_prefix}${res.expert_fullname}`
        );
    });

    get_expert_list(json.topic_id);
    return `<div class="row">
        <div class="col-md-12">
            <h2 class="text-center fw-bold text-blue"></h2>
            <div class="p-3 text-center">
                    <strong>รายละเอียดบทความ</strong>
                </div>

                <div class="p-3">
                    <table>
                        <tr>
                            <td style="text-wrap:nowrap;">รหัสบทความ: </td>
                            <td class="ps-3">${json.topic_id}</td>
                        </tr>
                        <tr>
                            <td style="text-wrap:nowrap;">ชื่อบทความ (ภาษาไทย): </td>
                            <td class="ps-3">${json.topic_th}</td>
                        </tr>
                        <tr>
                            <td style="text-wrap:nowrap;">ชื่อบทความ (ภาษาอังกฤษ): </td>
                            <td class="ps-3">${json.topic_en}</td>
                        </tr>
                    </table>
                </div>
                <hr />
            <p class="text-danger">ใส่ชื่อผู้ทรงคุณวุฒิเพื่อส่งไฟล์ไปให้ผู้ทรงคุณวุฒิ</p>
            <div class="d-flex w-100 justify-content-center position-relative gap-2">
                <input autocomplete="off" onfocusout="focusout_input()" onfocus="filter_data_input(this, '${list_expert}')" onkeyup="filter_data_input(this, '${list_expert}')" class="form-control my-auto" type="search" id="name_expert_input" placeholder="ค้นหาชื่อผู้ทรงคุณวุฒิ"/>
                <input type="hidden" id="name_expert_hidden"/>
                <button class="btn btn-outline-success text-nowrap rounded-0" onclick="add_expert('${json.topic_id}')" id="add_expert_user">ค้นหาผู้ทรงคุณวุฒิ</button>
                <ul style="top: 100%;z-index: 9999;" class="position-absolute search-list shadow"></ul>
                
            </div>

            <div id="expert-list-search"></div>
            <div class="w-100 mt-5">
                <p class="text-center">
                    <strong>รายชื่อผู้ทรงคุณวุฒิ</strong>
                </p>
                <div id="expert-list"></div>
            </div>
            
        </div>
    </div>`;
}

function confirm_delete_suggestion(topic_id, filename, file_id) {
    const _token = $('meta[name="csrf-token"]').attr("content");

    const json = get_data.replace(/[\u007F-\uFFFF]/g, function (chr) {
        return "\\u" + ("0000" + chr.charCodeAt(0).toString(16)).substr(-4);
    });

    let createModal = `
                <div id="form_modal_confirm"></div>
                    `;
    $("#modal").html(createModal);
    $("#modal_body").html(
        `<div class="text-center">กำลังโหลดข้อมูล กรุณารอสักครู่</div>`
    );
    $("#suggestion_modal").modal("hide");
    $("#suggestion_modal").modal("show");

    $("#form_modal_confirm").html(`
    <form enctype="multipart/form-data" method="POST" action="/backend/expert-file-delete/${file_id}">
        <div class="modal fade" id="suggestion_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="ลบไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            <input type="hidden" name="_method" value="DELETE" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">ลบไฟล์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal_body" class="modal-body">
                        ต้องการลบไฟล์ <strong class="text-red">"${filename}"</strong> หรือไม่ ?
                    </div>
                    <div id="modal_footer" class="modal-footer">
                        <button onclick="thisDisabled(this);delete_suggestion('${file_id}')" type="button" class="btn btn-success text-white rounded-0">ตกลง</button>
                        <button onclick="open_modal_default('#modal', 'xl', 'ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ', '${escape(
                            json
                        )}')" data-bs-dismiss="modal" type="button" class="btn btn-secondary text-white rounded-0">ย้อนกลับ</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    `);
    $("#suggestion_modal").modal("show");
}

function delete_suggestion(id) {
    const _token = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        method: "DELETE",
        url: `/backend/expert-file-delete/${id}`,
        data: { _token },
        success: function (res) {
            if (res == 1) {
                $("#suggestion_modal").modal("hide");
                open_modal_default(
                    "#modal",
                    "xl",
                    "ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ",
                    get_data
                );

                Swal.fire({
                    title: "สำเร็จ",
                    html: `ลบบทความแล้ว`,
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                });
            }
        },
    });
}

function confirm_delete_expert(expert_name, expert_id, sug_id) {
    const _token = $('meta[name="csrf-token"]').attr("content");

    const json = get_data.replace(/[\u007F-\uFFFF]/g, function (chr) {
        return "\\u" + ("0000" + chr.charCodeAt(0).toString(16)).substr(-4);
    });

    let createModal = `
                <div id="form_modal_confirm"></div>
                    `;
    $("#modal").html(createModal);
    $("#modal_body").html(
        `<div class="text-center">กำลังโหลดข้อมูล กรุณารอสักครู่</div>`
    );
    $("#suggestion_modal").modal("hide");
    $("#suggestion_modal").modal("show");

    $("#form_modal_confirm").html(`
    <form enctype="multipart/form-data" method="POST" action="/backend/expert-name-delete/${expert_id}">
        <div class="modal fade" id="suggestion_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="ลบไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            <input type="hidden" name="_method" value="DELETE" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">ลบไฟล์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal_body" class="modal-body">
                        ต้องการลบรายชื่อ <strong class="text-red">"${expert_name}"</strong> หรือไม่ ?
                    </div>
                    <div id="modal_footer" class="modal-footer">
                        <button onclick="thisDisabled(this);delete_expert('${sug_id}')" type="button" class="btn btn-success text-white rounded-0">ตกลง</button>
                        <button onclick="open_modal_default('#modal', 'xl', 'ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ', '${escape(
                            json
                        )}')" data-bs-dismiss="modal" type="button" class="btn btn-secondary text-white rounded-0">ย้อนกลับ</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    `);
    $("#suggestion_modal").modal("show");
}

function delete_expert(id) {
    const _token = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        method: "DELETE",
        url: `/backend/expert-name-delete/${id}`,
        data: { _token },
        success: function (res) {
            if (res == 1) {
                $("#suggestion_modal").modal("hide");
                open_modal_default(
                    "#modal",
                    "xl",
                    "ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ",
                    get_data
                );

                Swal.fire({
                    title: "สำเร็จ",
                    html: `ลบรายชื่อสำเร็จ`,
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                });
            } else {
                $("#suggestion_modal").modal("hide");
                open_modal_default(
                    "#modal",
                    "xl",
                    "ลิงค์ผู้ทรง ฯ ส่งไฟล์ข้อเสนอแนะ",
                    get_data
                );

                Swal.fire({
                    title: "ผิดพลาด",
                    html: `ไม่สามารถลบรายชื่อได้`,
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                });
            }
        },
    });
}

function escape(htmlStr) {
    return htmlStr
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}
