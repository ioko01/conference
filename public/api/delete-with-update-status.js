"use strict";

const open_modal = (topic, route) => {
    delete_entry(topic, route);
};

const delete_entry = (topic, route) => {
    const _token = $('meta[name="csrf-token"]').attr("content");
    let createModal = `
    <div class="modal fade" id="video_poster_modal" data-bs-backdrop="static"
    data-bs-keyboard="true" tabindex="-1" aria-labelledby="ลบรายการ" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="${route}" method="POST">
                    <input type="hidden" name="_token" value="${_token}" />
                    <input type="hidden" name="_method" value="PUT" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">ยืนยันการลบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_body">
                        <label style="word-break: break-word;" for="poster">ต้องการลบ <span class="text-danger">"${topic}"</span> หรือไม่?</label>
                    </div>
                    <div class="modal-footer">
                        <button onclick="thisDisabled(this)" type="submit" class="btn btn-danger rounded-0">
                            <i class="fa fa-trash-alt"></i> ลบ
                        </button>
                        <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal"><i class="fas fa-times"></i> ปิด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;

    $("#modal").html(createModal);
    $("#video_poster_modal").modal("show");
};
