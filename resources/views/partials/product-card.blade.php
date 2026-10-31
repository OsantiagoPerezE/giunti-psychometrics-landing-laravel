@use('App\Support\Catalog')
@php
    $isCourse = $product['kind'] === 'corso';
    $promo = Catalog::hasPromo($product);
    $formatModifier = \Illuminate\Support\Str::slug($product['format']);
@endphp

<article class="product-card" data-name="{{ $product['name'] }}" data-category="{{ $product['category'] }}"
    data-format="{{ $product['format'] }}" data-topics="{{ implode(' ', $product['topics']) }}"
    data-constructs="{{ implode(' ', $product['constructs']) }}" data-price="{{ Catalog::finalPrice($product) }}">
    <div class="product-card__media">
        <img src="{{ $product['image'] }}" alt="{{ $product['image_alt'] }}" class="product-card__image" loading="lazy">
        @if ($isCourse)
            <div class="product-card__course">
                <p class="product-card__course-type">
                    {{ $product['format'] === 'In presenza' ? 'Corso in presenza' : 'Corso online' }}</p>
                <p class="product-card__course-info">{{ $product['hours'] }} ore | {{ $product['ecm'] }} ECM</p>
            </div>
        @endif
        <span class="badge badge--{{ $formatModifier }} product-card__badge">{{ $product['format'] }}</span>
    </div>

    <div class="product-card__body">
        <h3 class="product-card__title">{{ $product['name'] }}</h3>
        <p class="product-card__meta">{{ $isCourse ? 'Docente' : 'Autore' }}: {{ $product['author'] }}</p>
        <p class="product-card__meta">
            @if ($isCourse && isset($product['start_date']))
                Inizio: {{ Catalog::formatDate($product['start_date']) }}
            @else
                Età di applicazione: {{ $product['age_range'] }}
            @endif
        </p>

        <div class="price product-card__price">
            <div class="price__row">
                <span class="price__final">{{ Catalog::formatPrice(Catalog::finalPrice($product)) }}</span>
                @if ($promo)
                    <span class="price__discount">-{{ Catalog::discountPercent($product) }}%</span>
                @endif
            </div>
            @if ($promo)
                <p class="price__original"><span class="sr-only">Prezzo originale:
                    </span><s>{{ Catalog::formatPrice($product['price']) }}</s></p>
            @endif
        </div>

        @if ($isCourse)
            <button type="button" class="button button--primary button--pill product-card__action">
                Scopri di più
                <span aria-hidden="true" class="button__arrow">→</span>
                <span class="sr-only">: {{ $product['name'] }}</span>
            </button>
        @else
            <button type="button" class="button button--primary button--pill product-card__action" data-add-to-cart>
                <span class="product-card__action-label">Aggiungi al carrello</span>
                <span aria-hidden="true" class="button__arrow">→</span>
                <span class="sr-only">: {{ $product['name'] }}</span>
            </button>
        @endif
    </div>
</article>