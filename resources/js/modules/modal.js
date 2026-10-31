import $ from "jquery";

export function openModal(dialog) {
    if (!dialog || dialog.open) return;
    dialog.showModal();
    $("html").addClass("has-modal");
}

export function closeModal(dialog) {
    if (dialog?.open) dialog.close();
}

export function initModals() {
    $("dialog.modal")
        .on("close", () => $("html").removeClass("has-modal"))
        .on("click", function (e) {
            if (e.target === this) closeModal(this);
        })
        .on("click", "[data-modal-close]", function () {
            closeModal($(this).closest("dialog")[0]);
        });
}
