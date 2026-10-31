@use('App\Support\Catalog')

@if ($heroProduct)
    <section id="hero" class="hero" aria-labelledby="hero-titolo">
        <img src="{{ $heroProduct['image'] }}" alt="" class="hero__image" fetchpriority="high">
        <div class="hero__overlay" aria-hidden="true"></div>

        <div class="hero__inner">
            <div class="hero__content">
                <p class="hero__badge">{{ $hero['badge'] }}</p>
                <h1 id="hero-titolo" class="hero__title">{{ $heroProduct['name'] }}</h1>
                <p class="hero__description">{{ $heroProduct['description'] }}</p>
                <div class="hero__actions">
                    <a href="{{ $hero['cta']['href'] }}" class="button button--accent button--large hero__cta">
                        {{ $hero['cta']['label'] }}
                        <span aria-hidden="true" class="button__arrow">→</span>
                    </a>
                    <a href="/#catalogo" class="button button--outline-light hero__product">{{ $hero['product_cta'] }}</a>
                </div>
            </div>

            @if (Catalog::hasPromo($heroProduct))
                <div class="hero__promo">
                    <span class="hero__promo-percent">-{{ Catalog::discountPercent($heroProduct) }}%</span>
                    <span class="hero__promo-name">{{ $heroProduct['name'] }}</span>
                </div>
            @endif
        </div>
    </section>
@endif