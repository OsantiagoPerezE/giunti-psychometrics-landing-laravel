import $ from "jquery";
import { createProductSlider } from "./product-slider";
import { normalize, scrollToCatalog } from "./utils";
import { openModal } from "./modal";

const ADDED_MS = 1400;

export function initCatalog() {
    const $section = $("#catalogo");
    if (!$section.length) return null;

    const state = {
        query: "",
        category: "tutti",
        taxonomy: null,
        formats: [],
        priceMin: null,
        priceMax: null,
    };

    const $slider = $section.find("[data-product-slider]");
    const $pool = $slider.find(".product-slider__pool");
    const items = $pool.children().toArray();
    $pool.remove();
    const slider = createProductSlider($slider);

    const $search = $("#cerca-catalogo");
    const $clearSearch = $section.find(".catalog-search__clear");
    const $pills = $section.find(".pill");
    const $scroller = $section.find(".category-filter__scroller");
    const $count = $section.find(".catalog__count");
    const $empty = $section.find(".catalog__empty");
    const $chipQuery = $section.find("[data-clear-query]");
    const $chipTaxonomy = $section.find("[data-clear-taxonomy]");
    const $chipFilters = $section.find("[data-clear-filters]");
    const $filterButton = $section.find("[data-open-filters]");

    const $modal = $("[data-filters-modal]");
    const $formatInputs = $modal.find("[data-filter-format]");
    const $min = $modal.find("[data-filter-min]");
    const $max = $modal.find("[data-filter-max]");

    const advancedCount = () =>
        state.formats.length +
        (state.priceMin !== null || state.priceMax !== null ? 1 : 0);

    const matches = (card) => {
        const price = Number(card.dataset.price);
        return (
            (state.category === "tutti" ||
                card.dataset.category === state.category) &&
            (!state.taxonomy ||
                card.dataset[state.taxonomy.type]
                    .split(" ")
                    .includes(state.taxonomy.slug)) &&
            normalize(card.dataset.name).includes(
                normalize(state.query.trim()),
            ) &&
            (state.formats.length === 0 ||
                state.formats.includes(card.dataset.format)) &&
            (state.priceMin === null || price >= state.priceMin) &&
            (state.priceMax === null || price <= state.priceMax)
        );
    };

    const render = () => {
        const visible = items.filter((li) =>
            matches(li.querySelector(".product-card")),
        );
        const n = visible.length;
        const query = state.query.trim();
        const active = advancedCount();

        $count.text(n === 1 ? "1 prodotto trovato" : `${n} prodotti trovati`);
        $empty.prop("hidden", n > 0);
        $slider.prop("hidden", n === 0);
        slider.render(visible);

        $chipQuery
            .prop("hidden", !query)
            .find(".chip__label")
            .text(`Ricerca: «${query}»`);
        const { taxonomy } = state;
        $chipTaxonomy
            .prop("hidden", !taxonomy)
            .find(".chip__label")
            .text(
                taxonomy
                    ? `${taxonomy.type === "topics" ? "Tema" : "Costrutto"}: ${taxonomy.label}`
                    : "",
            );
        $chipFilters
            .prop("hidden", active === 0)
            .find(".chip__label")
            .text(`Filtri attivi: ${active}`);
        $filterButton.toggleClass("is-active", active > 0);
        $filterButton
            .find(".filter-button__count")
            .prop("hidden", active === 0)
            .text(active);

        $modal
            .find(".filters-modal__show")
            .text(n === 1 ? "Mostra 1 prodotto" : `Mostra ${n} prodotti`);
        $modal.find("[data-filters-reset]").prop("disabled", active === 0);
    };

    const setQuery = (value) => {
        state.query = value;
        if ($search.val() !== value) $search.val(value);
        $clearSearch.prop("hidden", !value);
        render();
    };

    const setCategory = (id) => {
        state.category = id;
        $pills.each(function () {
            const isActive = this.dataset.category === id;
            $(this)
                .toggleClass("is-active", isActive)
                .attr("aria-pressed", String(isActive));
        });
        centerActivePill();
        render();
    };

    const setTaxonomy = (taxonomy) => {
        state.taxonomy = taxonomy;
        render();
    };

    const resetFilters = () => {
        state.formats = [];
        state.priceMin = null;
        state.priceMax = null;
        $formatInputs.prop("checked", false);
        $min.val("");
        $max.val("");
        render();
    };

    function centerActivePill() {
        const row = $scroller[0];
        const pill = $pills.filter(".is-active")[0];
        if (!row || !pill) return;
        const offset =
            pill.getBoundingClientRect().left -
            row.getBoundingClientRect().left +
            row.scrollLeft;
        row.scrollTo({
            left: offset - (row.clientWidth - pill.offsetWidth) / 2,
            behavior: "smooth",
        });
    }

    const $arrowPrev = $section.find(".category-filter__arrow--prev");
    const $arrowNext = $section.find(".category-filter__arrow--next");
    const $fadePrev = $section.find(".category-filter__fade--prev");
    const $fadeNext = $section.find(".category-filter__fade--next");
    const measureEdges = () => {
        const el = $scroller[0];
        const atStart = el.scrollLeft <= 4;
        const atEnd = el.scrollLeft + el.clientWidth >= el.scrollWidth - 4;
        $arrowPrev.add($fadePrev).prop("hidden", atStart);
        $arrowNext.add($fadeNext).prop("hidden", atEnd);
    };
    const scrollPills = (dir) =>
        $scroller[0].scrollBy({
            left: dir * $scroller[0].clientWidth * 0.7,
            behavior: "smooth",
        });

    $pills.on("click", function () {
        setCategory(this.dataset.category);
    });
    $scroller.on("scroll", measureEdges);
    $(window).on("resize", measureEdges);
    $arrowPrev.on("click", () => scrollPills(-1));
    $arrowNext.on("click", () => scrollPills(1));

    const showOnly = ({ category = "tutti", taxonomy = null }) => {
        resetFilters();
        setQuery("");
        setTaxonomy(taxonomy);
        setCategory(category);
    };
    const taxonomyFor = (type, slug) => {
        const attr =
            type === "topics" ? "data-set-topic" : "data-set-construct";
        const label = $(`[${attr}="${slug}"]`).first().text().trim();
        return label ? { type, slug, label } : null;
    };
    const jump = (e, filters) => {
        e.preventDefault();
        showOnly(filters);
        scrollToCatalog();
    };
    $(document).on("click", "[data-set-category]", function (e) {
        jump(e, { category: this.dataset.setCategory });
    });
    $(document).on(
        "click",
        "[data-set-topic], [data-set-construct]",
        function (e) {
            const type = this.dataset.setTopic ? "topics" : "constructs";
            jump(e, {
                taxonomy: taxonomyFor(
                    type,
                    this.dataset.setTopic || this.dataset.setConstruct,
                ),
            });
        },
    );
    $(document).on("click", "[data-show-all]", (e) => jump(e, {}));

    $section
        .find("[data-catalog-search]")
        .on("submit", (e) => e.preventDefault());
    $search.on("input", () => setQuery($search.val()));
    $clearSearch.on("click", () => {
        setQuery("");
        $search.trigger("focus");
    });
    $chipQuery.on("click", () => setQuery(""));
    $chipTaxonomy.on("click", () => setTaxonomy(null));
    $chipFilters.on("click", resetFilters);

    const parse = (value) =>
        value === "" || Number.isNaN(Number(value)) || Number(value) < 0
            ? null
            : Number(value);

    $filterButton.on("click", () => openModal($modal[0]));
    $formatInputs.on("change", () => {
        state.formats = $formatInputs
            .filter(":checked")
            .map((_, el) => el.value)
            .get();
        render();
    });
    $min.on("input", () => {
        state.priceMin = parse($min.val());
        render();
    });
    $max.on("input", () => {
        state.priceMax = parse($max.val());
        render();
    });
    $modal.find("[data-filters-reset]").on("click", resetFilters);

    $(document).on("click", "[data-add-to-cart]", function () {
        const $button = $(this);
        clearTimeout($button.data("timer"));
        $button.addClass("is-done");
        $button.find(".product-card__action-label").text("Aggiunto");
        $button.find(".button__arrow").text("✓");
        $button.data(
            "timer",
            setTimeout(() => {
                $button.removeClass("is-done");
                $button
                    .find(".product-card__action-label")
                    .text("Aggiungi al carrello");
                $button.find(".button__arrow").text("→");
            }, ADDED_MS),
        );
    });

    render();
    measureEdges();
    document.fonts?.ready.then(measureEdges);
    if ("ResizeObserver" in window) {
        const observer = new ResizeObserver(measureEdges);
        [$scroller[0], ...$pills.toArray()].forEach((el) =>
            observer.observe(el),
        );
    }

    const params = new URLSearchParams(window.location.search);
    if (["categoria", "tema", "costrutto", "q"].some((k) => params.has(k))) {
        const category = params.get("categoria");
        const validCategory =
            $pills.filter((_, el) => el.dataset.category === category).length >
            0;
        showOnly({
            category: validCategory ? category : "tutti",
            taxonomy: params.has("tema")
                ? taxonomyFor("topics", params.get("tema"))
                : params.has("costrutto")
                  ? taxonomyFor("constructs", params.get("costrutto"))
                  : null,
        });
        if (params.has("q")) setQuery(params.get("q"));
        window.history.replaceState(null, "", "/#catalogo");
    }

    return {
        showSearch(value) {
            showOnly({});
            setQuery(value);
            scrollToCatalog();
        },
    };
}
