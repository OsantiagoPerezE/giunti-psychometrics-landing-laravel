import $ from "jquery";

const DESKTOP = window.matchMedia("(min-width: 1280px)");
const TABLET = window.matchMedia("(min-width: 768px)");
const SWIPE_MIN_PX = 50;

const perSlide = () => (DESKTOP.matches ? 3 : TABLET.matches ? 2 : 1);

export function createProductSlider($root) {
    const $track = $root.find(".product-slider__track");
    const $prev = $root.find(".product-slider__arrow--prev");
    const $next = $root.find(".product-slider__arrow--next");
    const $dots = $root.find(".product-slider__dots");
    let items = [];
    let page = 0;
    let total = 0;

    const go = (n) => {
        page = Math.max(0, Math.min(total - 1, n));
        $track.css("transform", `translateX(calc(${-page} * (100% + 24px)))`);
        $track.children().each(function (i) {
            this.inert = i !== page;
        });
        $prev.prop("disabled", page === 0);
        $next.prop("disabled", page === total - 1);
        $dots.children().each(function (i) {
            if (i === page) this.setAttribute("aria-current", "true");
            else this.removeAttribute("aria-current");
        });
    };

    const build = () => {
        const size = perSlide();
        $track.find(".product-grid__item").detach();
        $track.empty();
        total = Math.ceil(items.length / size);
        for (let i = 0; i < total; i += 1) {
            const $list = $('<ul class="product-grid"></ul>').append(
                items.slice(i * size, (i + 1) * size),
            );
            $(
                '<div class="product-slider__slide" role="group" aria-roledescription="slide"></div>',
            )
                .attr("aria-label", `${i + 1} di ${total}`)
                .append($list)
                .appendTo($track);
        }
        $dots.empty();
        if (total > 1) {
            for (let i = 0; i < total; i += 1) {
                $('<button type="button" class="product-slider__dot"></button>')
                    .attr("aria-label", `Vai alla pagina ${i + 1}`)
                    .on("click", () => go(i))
                    .appendTo($dots);
            }
        }
        $prev.add($next).prop("hidden", total <= 1);
        go(Math.min(page, Math.max(0, total - 1)));
    };

    $prev.on("click", () => go(page - 1));
    $next.on("click", () => go(page + 1));
    $root.on("keydown", (e) => {
        if (e.key === "ArrowLeft") go(page - 1);
        if (e.key === "ArrowRight") go(page + 1);
    });

    let touchX = null;
    $root.on("touchstart", (e) => {
        touchX = e.originalEvent.touches[0].clientX;
    });
    $root.on("touchend", (e) => {
        if (touchX === null) return;
        const dx = e.originalEvent.changedTouches[0].clientX - touchX;
        touchX = null;
        if (Math.abs(dx) >= SWIPE_MIN_PX) go(page + (dx < 0 ? 1 : -1));
    });

    [DESKTOP, TABLET].forEach((q) => q.addEventListener("change", build));

    return {
        render(next) {
            items = next;
            page = 0;
            build();
        },
    };
}
