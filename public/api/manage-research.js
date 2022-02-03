"use strict";

function detail_modal(topic_id) {
    $.ajax({
        method: "GET",
        url: "/api/show-research-detail/" + topic_id,
        success: function (res) {
            res.forEach(data => {
                const createModal = `<div class="modal fade" id="research_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="รายละเอียด" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">รายละเอียดทั้งหมด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                            class="text-dark">${data.presenter}</span>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-green rounded-0 text-white">บันทึกและปิด</button>
                    </div>
                </div>
            </div>
        </div>`;

                $("#modal").html(createModal);
                $('#research_modal').modal('show');
            });

        }
    })

}

function update_modal(topic_id, type, title, status_value, text_status) {
    const createModal = `<div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-labelledby="${type}" aria-hidden="true">
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
                <button type="button" class="btn btn-green rounded-0 text-white" onclick="update_status(${topic_id}, ${status_value})">ตกลง</button>
                <button type="button" class="btn btn-danger rounded-0 text-white"
                    data-bs-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>`;

    $("#modal").html(createModal);
    $('#research_modal').modal('show');
}

function open_modal(e, type) {
    try {
        const topic_id = e.nextElementSibling.value;
        const title = type;
        const status_value = e.value;
        const text_status = type == 'เปลี่ยนสถานะ' ? e[e.selectedIndex].text : null;
        return type == 'เปลี่ยนสถานะ' ? update_modal(topic_id, type, title, status_value, text_status) : detail_modal(topic_id, type);
    } catch (error) {
        throw error;
    }
}


function update_status(topic_id, status) {
    try {
        const _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "PUT",
            url: "/api/update-status/" + topic_id,
            data: {
                topic_status: status,
                _token
            },
            success: function (data) {
                data.success ? window.location.replace('/admin/research') : null;
            },
            error: function (error) {
                console.log(error);
            }
        });
    } catch (error) {
        throw error;
    }
}
