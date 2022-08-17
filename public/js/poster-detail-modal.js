"use strict";

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    return `<div class="row">
    <h2 class="text-center fw-bold text-blue">${data.present_poster_id}</h2>
    <p class="h5"><span>ชื่อบทความ : </span><span class="text-success">${data.topic_th}</span></p>
    <p class="h5"><span>Link</span> : </span><a target="_blank" href="${data.link}">${data.link}</a></p>
    <hr />
    <img src="${data.path}" class="img-fluid" alt="${data.topic_th}">
    </div>`;
}
