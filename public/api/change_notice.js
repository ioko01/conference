"use strict";

const open_modal_notice = (e, topic, route) => {
    const value = e.value;
    change_notice(value, topic, route);
};

const change_notice = (value, topic, route) => {
    const _token = $('meta[name="csrf-token"]').attr("content");
    let createModal = `
    <div class="modal fade" id="notice_modal" data-bs-backdrop="static"
    data-bs-keyboard="true" tabindex="-1" aria-labelledby="ประชาสัมพันธ์" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="${route}" method="POST">
                    <input type="hidden" name="_token" value="${_token}" />
                    <input type="hidden" name="_method" value="PUT" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">ประชาสัมพันธ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">
                        <label for="poster">ต้องการ <span class="text-danger">"${
                            value == "1" ? `ยกเลิก` : `นำ`
                        } ${topic}"</span> ขึ้นประชาสัมพันธ์หรือไม่?</label>
                    <input type="hidden" name="notice" value=${value}>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success rounded-0">
                            <i class="fa fa-save"></i> บันทึก
                        </button>
                        <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal">ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#notice_modal").modal("show");
    $("#notice_modal").on("hidden.bs.modal", function (e) {
        location.reload();
    });
};
