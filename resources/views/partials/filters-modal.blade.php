@use('App\Support\Catalog')
@php([$minPrice, $maxPrice] = Catalog::priceRange())

<dialog id="filtri-modal" class="modal modal--filters" aria-labelledby="filtri-titolo" data-filters-modal>
    <div class="modal__body filters-modal">
        <div class="modal__head">
            <h2 id="filtri-titolo" class="filters-modal__title">Filtri</h2>
            <button type="button" class="modal__close modal__close--small" aria-label="Chiudi i filtri"
                data-modal-close>
                @include('partials.icon', ['d' => 'M6 6l12 12M18 6 6 18', 'stroke' => 2])
            </button>
        </div>

        <fieldset class="filters-modal__group">
            <legend class="filters-modal__legend">Formato</legend>
            <div class="filters-modal__options">
                @foreach (config('catalog.formats') as $format)
                    <label class="toggle-pill">
                        <input type="checkbox" class="toggle-pill__input sr-only" value="{{ $format }}" data-filter-format>
                        <span class="toggle-pill__label">{{ $format }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>

        <fieldset class="filters-modal__group">
            <legend class="filters-modal__legend">Prezzo</legend>
            <div class="filters-modal__prices">
                <div>
                    <label for="prezzo-min" class="filters-modal__label">Da (€)</label>
                    <input id="prezzo-min" type="number" inputmode="numeric" min="0" class="input"
                        placeholder="{{ $minPrice }}" data-filter-min>
                </div>
                <div>
                    <label for="prezzo-max" class="filters-modal__label">A (€)</label>
                    <input id="prezzo-max" type="number" inputmode="numeric" min="0" class="input"
                        placeholder="{{ $maxPrice }}" data-filter-max>
                </div>
            </div>
            <p class="filters-modal__range">Prezzi da {{ Catalog::formatPrice($minPrice) }} a
                {{ Catalog::formatPrice($maxPrice) }}</p>
        </fieldset>

        <div class="filters-modal__actions">
            <button type="button" class="filters-modal__reset" data-filters-reset disabled>Azzera filtri</button>
            <button type="button" class="button button--primary filters-modal__show" data-modal-close>Mostra
                {{ count($products) }} prodotti</button>
        </div>
    </div>
</dialog>