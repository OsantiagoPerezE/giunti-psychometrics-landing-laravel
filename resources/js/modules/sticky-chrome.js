import $ from "jquery";

const COLLAPSE_AT = 48;
const EXPAND_AT = 24;

export function initStickyChrome() {
    const $chrome = $("[data-sticky-chrome]");
    if (!$chrome.length) return;

    let scrolled = false;
    let frame = 0;

    const update = () => {
        frame = 0;
        const y = window.scrollY;
        const max = document.documentElement.scrollHeight - window.innerHeight;
        $chrome[0].style.setProperty(
            "--scroll",
            String(max > 0 ? Math.min(y / max, 1) : 0),
        );
        scrolled = scrolled ? y > EXPAND_AT : y > COLLAPSE_AT;
        $chrome.toggleClass("is-scrolled", scrolled);
    };
    const onScroll = () => {
        if (!frame) frame = requestAnimationFrame(update);
    };

    update();
    $(window).on("scroll resize", onScroll);
}
