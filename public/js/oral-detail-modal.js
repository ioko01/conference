"use strict";

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    return `<div class="row">
        <div class="col-md-12 text-center">
            <h2 class="text-center fw-bold text-blue">${data.room}</h2>
            <p class="h5"><span>Link</span> : </span><a target="_blank" href="${data.link}">${data.link}</a></p>
            <img src="${data.path}" class="img-fluid" alt="${data.room}">
        </div>
    </div>`;
}
