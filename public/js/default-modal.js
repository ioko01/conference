"use strict";

/**
 * เป็นฟังก์ชันที่เอาไว้เปิด modal ที่มี content เป็นการ์ด
 * @property {String} themeSetting
 * @param {String} modalId
 * @param {String | undefined} themeSetting
 * @param {String | undefined} textTitle
 * @param {String | undefined} modalSize
 * @param {String | String[] | object} data
 * @default themeSetting = "primary"
 */

function open_modal_default(modalId, modalSize = "sm", textTitle, data) {
    /**
     *  @param {String | String[] | object} data
     */
    const detail = modal_detail(data);
    let createModal = `
            <div style="overflow: auto;" class="modal fade" id="card_modal" data-bs-backdrop="static"
            data-bs-keyboard="true" tabindex="-1" aria-labelledby="${textTitle}" aria-hidden="true">
                <div class="modal-dialog modal-${modalSize}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="staticBackdropLabel">${textTitle}</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_body">${detail}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0"
                                data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>`;

    $(modalId).html(createModal);
    $("#card_modal").modal("show");
}
