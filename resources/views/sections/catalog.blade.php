<section id="catalogo" class="catalog section" aria-labelledby="catalogo-titolo">
    <div class="catalog__header reveal">
        <h2 id="catalogo-titolo" class="section__title">Test per l'assessment psicologico e corsi professionali</h2>
        <a href="/#catalogo" class="button button--outline catalog__all" data-show-all>
            Vedi tutto il catalogo
            <span aria-hidden="true" class="button__arrow">→</span>
        </a>
    </div>

    <div class="catalog__toolbar reveal">
        <div class="category-filter" data-category-filter>
            <div class="category-filter__fade category-filter__fade--prev" aria-hidden="true" hidden></div>
            <div class="category-filter__fade category-filter__fade--next" aria-hidden="true" hidden></div>
            <button type="button" class="category-filter__arrow category-filter__arrow--prev"
                aria-label="Categorie precedenti" hidden>
                @include('partials.icon', ['d' => 'm15 6-6 6 6 6', 'class' => 'icon icon--small', 'stroke' => 2.4])
            </button>
            <div class="category-filter__scroller" role="group" aria-label="Filtra per categoria">
                <button type="button" class="pill is-active" aria-pressed="true" data-category="tutti">
                    Tutti
                </button>
                @foreach ($categories as $category)
                    <button type="button" class="pill" aria-pressed="false" data-category="{{ $category['id'] }}">
                        {{ $category['label'] }}
                    </button>
                @endforeach
            </div>
            <button type="button" class="category-filter__arrow category-filter__arrow--next"
                aria-label="Altre categorie" hidden>
                @include('partials.icon', ['d' => 'm9 6 6 6-6 6', 'class' => 'icon icon--small', 'stroke' => 2.4])
            </button>
        </div>

        <div class="catalog__tools">
            <form class="catalog-search" role="search" data-catalog-search>
                <label for="cerca-catalogo" class="sr-only">Cerca nei prodotti</label>
                @include('partials.icon', ['d' => 'M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM20 20l-3.5-3.5', 'class' => 'catalog-search__icon'])
                <input id="cerca-catalogo" type="search" class="catalog-search__input" placeholder="Cerca per nome…"
                    autocomplete="off">
                <button type="button" class="catalog-search__clear" aria-label="Cancella la ricerca" hidden>
                    @include('partials.icon', ['d' => 'M6 6l12 12M18 6 6 18', 'class' => 'icon icon--small', 'stroke' => 2])
                </button>
            </form>

            <button type="button" class="filter-button" aria-haspopup="dialog" aria-controls="filtri-modal"
                data-open-filters>
                @include('partials.icon', ['d' => 'M4 7h10M18 7h2M4 17h2M10 17h10M16 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM8 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4z'])
                Filtri
                <span class="filter-button__count" hidden></span>
            </button>
        </div>
    </div>

    <div class="catalog__status">
        <p class="catalog__count" role="status">{{ count($products) }} prodotti trovati</p>
        <button type="button" class="chip" data-clear-query hidden>
            <span class="chip__label"></span> <span aria-hidden="true">✕</span>
            <span class="sr-only">Rimuovi la ricerca</span>
        </button>
        <button type="button" class="chip" data-clear-taxonomy hidden>
            <span class="chip__label"></span> <span aria-hidden="true">✕</span>
            <span class="sr-only">Rimuovi il filtro</span>
        </button>
        <button type="button" class="chip" data-clear-filters hidden>
            <span class="chip__label"></span> <span aria-hidden="true">✕</span>
            <span class="sr-only">Azzera i filtri</span>
        </button>
    </div>

    <p class="catalog__empty" hidden>
        Nessun prodotto corrisponde alla ricerca. Prova con un altro nome, categoria o filtro.
    </p>

    <div class="product-slider" aria-roledescription="carousel" aria-label="Elenco prodotti" data-product-slider>
        <div class="product-slider__frame">
            <button type="button" class="product-slider__arrow product-slider__arrow--prev"
                aria-label="Pagina precedente" hidden>
                @include('partials.icon', ['d' => 'm15 6-6 6 6 6', 'stroke' => 2.2])
            </button>
            <div class="product-slider__viewport">
                <div class="product-slider__track">
                    <ul class="product-grid product-slider__pool">
                        @foreach ($products as $product)
                            <li class="product-grid__item">@include('partials.product-card', ['product' => $product])</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="product-slider__arrow product-slider__arrow--next"
                aria-label="Pagina successiva" hidden>
                @include('partials.icon', ['d' => 'm9 6 6 6-6 6', 'stroke' => 2.2])
            </button>
        </div>
        <div class="product-slider__dots"></div>
    </div>
</section>