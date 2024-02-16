"use strict";

const open_modal = (topic, route) => {
    reset_entry(topic, route);
};

const reset_entry = (topic, route) => {
    const _token = $('meta[name="csrf-token"]').attr("content");
    let createModal = `
    <div class="modal fade" id="reset_password" data-bs-backdrop="static"
    data-bs-keyboard="true" tabindex="-1" aria-labelledby="รีเซ็ต" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="${route}" method="POST">
                    <input type="hidden" name="_token" value="${_token}" />
                    <input type="hidden" name="_method" value="PUT" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">ยืนยัน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">
                        <label style="word-break: break-word;" for="poster">ต้องการรีเซ็ตรหัสผ่าน <span class="text-danger">"${topic}"</span> หรือไม่?</label>
                    </div>
                    <div class="modal-footer">
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-success rounded-0">
                            <i class="fa fa-check"></i> ตกลง
                        </button>
                        <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal"><i class="fas fa-times"></i> ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#reset_password").modal("show");
};
