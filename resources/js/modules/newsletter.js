import $ from "jquery";

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

export function initNewsletter() {
    const $form = $("[data-newsletter]");
    if (!$form.length) return;

    const $input = $("#newsletter-email");
    const $error = $("#newsletter-errore");

    $form.on("submit", (e) => {
        e.preventDefault();
        if (!EMAIL_RE.test(String($input.val()).trim())) {
            $error
                .text("Inserisci un indirizzo email valido.")
                .prop("hidden", false);
            $input
                .attr({
                    "aria-invalid": "true",
                    "aria-describedby": "newsletter-errore",
                })
                .trigger("focus");
            return;
        }
        $form.prop("hidden", true);
        $(".newsletter__done").prop("hidden", false);
    });
}
