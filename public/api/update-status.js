"use strict";

function open_update_status_modal(e, type) {
    try {
        const id = e.nextElementSibling.value;
        const title = type;
        const status_value = e.value;
        const text_status = e[e.selectedIndex].text;

        const createModal = `<div class="modal fade" id="status-update-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
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
                    <button type="button" class="btn btn-green rounded-0 text-white" onclick="update_status(${id}, ${status_value})">ตกลง</button>
                    <button type="button" class="btn btn-danger rounded-0 text-white"
                        data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>`;

        $("#modal").html(createModal);
        const modal = new bootstrap.Modal(
            document.getElementById("status-update-modal")
        );
        modal.show();
    } catch (error) {
        throw error;
    }
}


function update_status(id, status) {
    try {
        const _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "PUT",
            url: "/api/update-status/" + id,
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
