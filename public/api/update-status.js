"use strict";

function open_status_update_modal() {
    const modal = new bootstrap.Modal(
        document.getElementById("status-update-modal")
    );
    const selection = $("#topic_status option:selected");
    const text = $("#text-status");
    text.html(selection.text());
    modal.show();
}