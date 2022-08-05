"use strict";

function delete_present_poster_modal(id, topic_th) {
    const _token = $('meta[name="csrf-token"]').attr("content");
    const createModal = `
    <form enctype="multipart/form-data" method="POST" action="/backend/${id}/delete">
        <div class="modal fade" id="research_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
        aria-labelledby="อัพโหลดไฟล์" aria-hidden="true">
            <input type="hidden" name="_token" value="${_token}" />
            <input type="hidden" name="_method" value="DELETE" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <label style="word-break: break-word;" for="poster">ต้องการลบหัวข้อ <span class="text-danger">"${topic_th}"</span> หรือไม่?</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger rounded-0">
                            <i class="fa fa-trash-alt"></i> ลบ
                        </button>
                        <button type="button" class="btn btn-secondary rounded-0"
                            data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `;
    $("#modal").html(createModal);
    $("#research_modal").modal("show");
}

function open_modal_present_poster(id, topic_th) {}
