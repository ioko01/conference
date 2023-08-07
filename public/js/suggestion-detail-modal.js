"use strict";

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    const json = JSON.parse(data);
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
            <p class="text-danger">สามารถคัดลอกลิงค์นี้เพื่อส่งให้ผู้ทรงคุณวุฒิเพิ่มไฟล์เข้ามาในระบบได้ผ่านลิงค์ด้านล่างนี้</p>
            <div class="d-flex w-100 justify-content-center">
                <input class="form-control my-auto" type="text" value="${json.link}" disabled/>
                <button style="min-width:180px;" class="btn rounded-0 m-2 btn-outline-success text-nowrap" onclick="copyText(this, '${json.link}')"><i class="fas fa-copy"></i> คัดลอกลิงค์</button>
            </div>
        </div>
    </div>`;
}
