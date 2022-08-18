"use strict";

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    return `<div class="row">
    <p class="h5"><span>ชื่อบทความ : </span><span class="text-success">${
        data.topic_th
    }</span></p>
    <p class="h5"><span>ผู้นำเสนอ</span> : </span><span class="text-success">${data.presenter.replace(
        "|",
        ", "
    )}</span></p>
    <p class="h5"><span>Link</span> : </span><a target="_blank" href="${
        data.video_link
    }">${data.video_link}</a></p>
    <hr />
    <img src="${data.poster_path}" class="img-fluid" alt="${data.topic_th}">
    </div>`;
}
