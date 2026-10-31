import $ from "jquery";

const CLOSE_DELAY_MS = 250;

export function initDropdowns() {
    $("[data-dropdown]").each(function () {
        const $root = $(this);
        const $toggle = $root.find(".dropdown__toggle");
        const $panel = $root.find(".dropdown__panel");
        let pinned = false;
        let timer;

        const setOpen = (open) => {
            $root.toggleClass("is-open", open);
            $toggle.attr("aria-expanded", String(open));
            $panel.prop("hidden", !open);
        };
        const close = () => {
            clearTimeout(timer);
            pinned = false;
            setOpen(false);
        };
        const isOpen = () => $root.hasClass("is-open");

        $toggle.on("click", () => {
            clearTimeout(timer);
            if (isOpen() && pinned) close();
            else {
                pinned = true;
                setOpen(true);
            }
        });

        $root.on("pointerenter", (e) => {
            if (e.originalEvent.pointerType !== "mouse") return;
            clearTimeout(timer);
            setOpen(true);
        });
        $root.on("pointerleave", (e) => {
            if (e.originalEvent.pointerType !== "mouse" || pinned) return;
            clearTimeout(timer);
            timer = setTimeout(() => setOpen(false), CLOSE_DELAY_MS);
        });

        $root.on("click", "[data-dropdown-close]", close);
        $(document).on("mousedown", (e) => {
            if (isOpen() && !$root[0].contains(e.target)) close();
        });
        $(document).on("keydown", (e) => {
            if (e.key === "Escape" && isOpen()) {
                close();
                $toggle.trigger("focus");
            }
        });
    });
}
