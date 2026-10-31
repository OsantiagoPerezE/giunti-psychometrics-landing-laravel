import $ from "jquery";

const MEGA_CLOSE_DELAY_MS = 250;

export function initHeader() {
    const $header = $(".header");
    const $toggle = $header.find("[data-menu-toggle]");
    const $megaToggle = $header.find("[data-mega-toggle]");
    const $mega = $header.find("[data-mega-menu]");

    const setMenu = (open) => {
        $header.toggleClass("is-menu-open", open);
        $toggle.attr({
            "aria-expanded": String(open),
            "aria-label": open ? "Chiudi il menu" : "Apri il menu",
        });
    };

    let pinned = false;
    let timer;
    const megaOpen = () => $header.hasClass("is-mega-open");
    const setMega = (open) => {
        $header.toggleClass("is-mega-open", open);
        $megaToggle.attr("aria-expanded", String(open));
        $mega.prop("hidden", !open);
    };
    const closeMega = () => {
        clearTimeout(timer);
        pinned = false;
        setMega(false);
    };

    $megaToggle.on("click", () => {
        clearTimeout(timer);
        if (megaOpen() && pinned) closeMega();
        else {
            pinned = true;
            setMega(true);
        }
    });
    $megaToggle.add($mega).on("pointerenter", (e) => {
        if (e.originalEvent.pointerType !== "mouse") return;
        clearTimeout(timer);
        setMega(true);
    });
    $megaToggle.add($mega).on("pointerleave", (e) => {
        if (e.originalEvent.pointerType !== "mouse" || pinned) return;
        clearTimeout(timer);
        timer = setTimeout(() => setMega(false), MEGA_CLOSE_DELAY_MS);
    });
    $mega.on("click", "[data-mega-close]", () => {
        closeMega();
        $megaToggle.trigger("focus");
    });
    $mega.on("click", "a", () => {
        closeMega();
        setMenu(false);
    });
    $(document).on("mousedown", (e) => {
        if (megaOpen() && !$header[0].contains(e.target)) closeMega();
    });

    $toggle.on("click", () => {
        closeMega();
        setMenu(!$header.hasClass("is-menu-open"));
    });
    $header.on(
        "click",
        ".header__nav a, .header__nav button:not([data-mega-toggle])",
        () => setMenu(false),
    );

    $(document).on("keydown", (e) => {
        if (e.key !== "Escape") return;
        if (megaOpen()) {
            closeMega();
            $megaToggle.trigger("focus");
        } else if ($header.hasClass("is-menu-open")) {
            setMenu(false);
            $toggle.trigger("focus");
        }
    });

    const $links = $header.find("[data-nav-section]");
    const sections = ["hero", "catalogo", "risorse", "contatti"]
        .map((id) => document.getElementById(id))
        .filter(Boolean);
    if (!("IntersectionObserver" in window) || !sections.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                $links.each(function () {
                    const current = this.dataset.navSection === entry.target.id;
                    if (current) this.setAttribute("aria-current", "true");
                    else this.removeAttribute("aria-current");
                });
            });
        },
        { rootMargin: "-40% 0px -55% 0px" },
    );
    sections.forEach((el) => observer.observe(el));
}
