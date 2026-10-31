import $ from "jquery";

const FIELDS = ["nome", "email", "messaggio"];
const MIN_NAME = 2;
const MIN_MESSAGE = 10;
const SEND_DELAY_MS = 800;
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

function validate(values) {
    const errors = {};
    const nome = values.nome.trim();
    const email = values.email.trim();
    const messaggio = values.messaggio.trim();

    if (!nome) errors.nome = "Il nome è obbligatorio.";
    else if (nome.length < MIN_NAME)
        errors.nome = `Il nome deve contenere almeno ${MIN_NAME} caratteri.`;

    if (!email) errors.email = "L'email è obbligatoria.";
    else if (!EMAIL_RE.test(email))
        errors.email =
            "Inserisci un indirizzo email valido (es. nome@dominio.it).";

    if (!messaggio) errors.messaggio = "Il messaggio è obbligatorio.";
    else if (messaggio.length < MIN_MESSAGE)
        errors.messaggio = `Il messaggio deve contenere almeno ${MIN_MESSAGE} caratteri.`;

    return errors;
}

export function initContactForm() {
    const $form = $("[data-contact-form]");
    if (!$form.length) return;

    const $success = $("[data-contact-success]");
    const $summary = $form.find(".contact-form__summary");
    const $counter = $form.find(".contact-form__counter");
    const field = (name) => $form.find(`[name="${name}"]`);

    const touched = {};
    let attempted = false;
    let sending = false;

    const values = () =>
        Object.fromEntries(FIELDS.map((f) => [f, String(field(f).val())]));

    const paint = () => {
        const errors = validate(values());
        let visible = false;

        FIELDS.forEach((f) => {
            const message = touched[f] || attempted ? errors[f] : undefined;
            const $input = field(f);
            const $error = $(`#${f}-errore`);
            visible = visible || Boolean(message);

            $input.attr("aria-invalid", String(Boolean(message)));
            $error
                .prop("hidden", !message)
                .find(".contact-form__error-text")
                .text(message || "");
            const describedBy = [
                message ? `${f}-errore` : null,
                f === "messaggio" ? "messaggio-aiuto" : null,
            ]
                .filter(Boolean)
                .join(" ");
            if (describedBy) $input.attr("aria-describedby", describedBy);
            else $input.removeAttr("aria-describedby");
        });

        const length = values().messaggio.trim().length;
        $counter
            .toggleClass("is-valid", length >= MIN_MESSAGE)
            .text(
                `${length >= MIN_MESSAGE ? "✓ " : ""}${length}/${MIN_MESSAGE} caratteri minimi`,
            );
        $summary.prop("hidden", !(attempted && visible));
        return errors;
    };

    const setSending = (value) => {
        sending = value;
        $form.attr("aria-busy", String(value));
        $form.find("input, textarea, button").prop("disabled", value);
        $form.find(".contact-form__spinner").prop("hidden", !value);
        $form
            .find(".contact-form__submit-label")
            .text(value ? "Invio in corso…" : "Invia messaggio");
    };

    FIELDS.forEach((f) => {
        field(f)
            .on("blur", () => {
                touched[f] = true;
                paint();
            })
            .on("input", paint);
    });

    $form.on("submit", (e) => {
        e.preventDefault();
        if (sending) return;
        attempted = true;
        const errors = paint();
        const firstInvalid = FIELDS.find((f) => errors[f]);
        if (firstInvalid) {
            field(firstInvalid).trigger("focus");
            return;
        }

        const name = values().nome.trim();
        setSending(true);
        setTimeout(() => {
            setSending(false);
            $form.prop("hidden", true);
            $success
                .prop("hidden", false)
                .find(".contact-success__text")
                .text(
                    `Grazie, ${name}! Abbiamo ricevuto la tua richiesta e ti risponderemo il prima possibile.`,
                );
            $success.trigger("focus");
        }, SEND_DELAY_MS);
    });

    $success.find(".contact-success__again").on("click", () => {
        $form[0].reset();
        FIELDS.forEach((f) => delete touched[f]);
        attempted = false;
        paint();
        $success.prop("hidden", true);
        $form.prop("hidden", false);
        field("nome").trigger("focus");
    });

    paint();
}
