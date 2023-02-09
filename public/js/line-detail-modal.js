"use strict";

/**
 *
 * @param {String | String[]} data
 * @returns HTML Design
 */
function modal_detail(data) {
    return `<div class="row">
        <div class="col-md-12 text-center">
            <h2 class="text-center fw-bold text-blue">${data.conference_name}</h2>
            <p class="h5"><span>Link</span> : </span><a target="_blank" href="${data.line_link}">${data.line_link}</a></p>
            <img src="${data.line_path}" class="img-fluid" alt="${data.conference_name}">
        </div>
    </div>`;
}
