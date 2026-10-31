import $ from "jquery";

import { initStickyChrome } from "./modules/sticky-chrome";
import { initDropdowns } from "./modules/dropdown";
import { initHeader } from "./modules/header";
import { initModals } from "./modules/modal";
import { initCatalog } from "./modules/catalog";
import { initSearchModal } from "./modules/search-modal";
import { initContactForm } from "./modules/contact-form";
import { initNewsletter } from "./modules/newsletter";

window.$ = window.jQuery = $;

$(function () {
    initStickyChrome();
    initDropdowns();
    initHeader();
    initModals();
    const catalog = initCatalog();
    initSearchModal(catalog);
    initContactForm();
    initNewsletter();
});
