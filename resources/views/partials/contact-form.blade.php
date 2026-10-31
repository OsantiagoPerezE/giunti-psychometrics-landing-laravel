<form class="contact-form" novalidate data-contact-form>
    <p class="contact-form__hint">
        I campi contrassegnati con <span aria-hidden="true"
            class="contact-form__required contact-form__required--inline">*</span><span class="sr-only">un
            asterisco</span> sono obbligatori.
    </p>

    <div class="contact-form__field">
        <label for="nome" class="contact-form__label">Nome<span aria-hidden="true"
                class="contact-form__required">*</span></label>
        <input id="nome" name="nome" type="text" class="contact-form__input" autocomplete="name" maxlength="80"
            aria-required="true">
        <p id="nome-errore" class="contact-form__error" role="alert" hidden><svg aria-hidden="true" viewBox="0 0 24 24"
                class="contact-form__error-icon" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7.5v5M12 16.5h.01" />
            </svg><span class="contact-form__error-text"></span></p>
    </div>

    <div class="contact-form__field">
        <label for="email" class="contact-form__label">Email<span aria-hidden="true"
                class="contact-form__required">*</span></label>
        <input id="email" name="email" type="email" inputmode="email" class="contact-form__input" autocomplete="email"
            maxlength="120" aria-required="true">
        <p id="email-errore" class="contact-form__error" role="alert" hidden><svg aria-hidden="true" viewBox="0 0 24 24"
                class="contact-form__error-icon" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7.5v5M12 16.5h.01" />
            </svg><span class="contact-form__error-text"></span></p>
    </div>

    <div class="contact-form__field">
        <label for="messaggio" class="contact-form__label">Messaggio<span aria-hidden="true"
                class="contact-form__required">*</span></label>
        <textarea id="messaggio" name="messaggio" rows="5" class="contact-form__input" maxlength="1000"
            aria-required="true" aria-describedby="messaggio-aiuto"></textarea>
        <div class="contact-form__below">
            <p id="messaggio-errore" class="contact-form__error" role="alert" hidden><svg aria-hidden="true"
                    viewBox="0 0 24 24" class="contact-form__error-icon" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7.5v5M12 16.5h.01" />
                </svg><span class="contact-form__error-text"></span></p>
            <p id="messaggio-aiuto" class="contact-form__counter">0/10 caratteri minimi</p>
        </div>
    </div>

    <p class="contact-form__summary" role="alert" hidden>
        Controlla i campi evidenziati in rosso prima di inviare il messaggio.
    </p>

    <button type="submit" class="button button--primary button--pill contact-form__submit">
        <span class="spinner contact-form__spinner" aria-hidden="true" hidden></span>
        <span class="contact-form__submit-label">Invia messaggio</span>
    </button>
</form>

<div class="contact-success" tabindex="-1" role="status" hidden data-contact-success>
    <div class="contact-success__head">
        <span aria-hidden="true" class="contact-success__check">✓</span>
        <h4 class="contact-success__title">Messaggio inviato!</h4>
    </div>
    <p class="contact-success__text"></p>
    <button type="button" class="contact-success__again">Invia un altro messaggio</button>
</div>