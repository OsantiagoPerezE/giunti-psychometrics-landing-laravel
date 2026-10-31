import $ from "jquery";
import { closeModal, openModal } from "./modal";
import { normalize } from "./utils";

const MAX_RESULTS = 6;
const MAX_IDEAS = 4;

export function initSearchModal(catalog) {
    const $modal = $("[data-search-modal]");
    if (!$modal.length) return;

    const dialog = $modal[0];
    const $input = $("#ricerca-input");
    const $status = $modal.find(".search-modal__status");
    const $results = $modal.find(".search-modal__result");
    const $list = $modal.find(".search-modal__results");
    const $empty = $modal.find(".search-modal__empty");
    const $all = $modal.find(".search-modal__all");

    const update = () => {
        const q = normalize($input.val().trim());
        const matching = $results.filter((_, el) =>
            normalize(el.dataset.name).includes(q),
        );
        const limit = q ? MAX_RESULTS : MAX_IDEAS;

        $results.prop("hidden", true);
        matching.slice(0, limit).prop("hidden", false);

        const n = matching.length;
        $status.text(
            !q
                ? "Ti serve qualche idea?"
                : n === 0
                  ? "Nessun risultato per la tua ricerca"
                  : n === 1
                    ? "1 risultato"
                    : `${n} risultati`,
        );
        $list.prop("hidden", n === 0);
        $empty.prop("hidden", n > 0);
        $all.prop("hidden", !q || n === 0);
    };

    const show = (value) => {
        closeModal(dialog);
        if (catalog) catalog.showSearch(value);
        else
            window.location.href = `/?q=${encodeURIComponent(value.trim())}#catalogo`;
    };

    $("[data-open-search]").on("click", () => {
        openModal(dialog);
        update();
        $input.trigger("focus");
    });
    $input.on("input", update);
    $modal.find(".search-modal__form").on("submit", (e) => {
        e.preventDefault();
        show($input.val());
    });
    $all.on("click", () => show($input.val()));
    $results.on("click", ".search-modal__link", function () {
        const name = $(this).closest(".search-modal__result").data("name");
        $input.val(name);
        show(name);
    });

    update();
}
