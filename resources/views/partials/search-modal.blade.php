@use('App\Support\Catalog')
<dialog id="ricerca-modal" class="modal modal--search" aria-labelledby="ricerca-titolo" data-search-modal>
    <div class="modal__body search-modal">
        <div class="modal__head">
            <h2 id="ricerca-titolo" class="search-modal__title">Cerca in questo sito web</h2>
            <button type="button" class="modal__close" aria-label="Chiudi la ricerca" data-modal-close>
                @include('partials.icon', ['d' => 'M6 6l12 12M18 6 6 18', 'stroke' => 2])
            </button>
        </div>

        <form class="search-modal__form" role="search">
            <label for="ricerca-input" class="sr-only">Cerca un prodotto per nome</label>
            <input id="ricerca-input" type="search" class="search-modal__input" placeholder="Cerca…" autocomplete="off">
            <button type="submit" class="search-modal__submit" aria-label="Cerca">
                @include('partials.icon', ['d' => 'M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM20 20l-3.5-3.5'])
            </button>
        </form>

        <p class="search-modal__status" role="status">Ti serve qualche idea?</p>

        <ul class="search-modal__results">
            @foreach (Catalog::products() as $product)
                <li class="search-modal__result" data-name="{{ $product['name'] }}">
                    <button type="button" class="search-modal__link">
                        <span class="search-modal__thumb"><img src="{{ $product['image'] }}" alt="" loading="lazy"></span>
                        <span class="search-modal__name">{{ $product['name'] }}</span>
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="search-modal__empty" hidden>Prova con un altro nome di prodotto.</div>

        <div class="search-modal__footer">
            <button type="button" class="button button--outline search-modal__all" hidden>Vedi tutti i risultati nel
                catalogo</button>
        </div>
    </div>
</dialog>