<section class="promo-banners section" aria-label="In evidenza">
    <div class="promo-banners__grid">
        @foreach (config('catalog.promos') as $promo)
            <article class="promo-banner {{ $loop->first ? 'promo-banner--large' : '' }}">
                <img src="{{ $promo['image'] }}" alt="{{ $promo['alt'] }}" class="promo-banner__image" loading="lazy">
                <div class="promo-banner__overlay" aria-hidden="true"></div>

                <div class="promo-banner__content">
                    <p class="promo-banner__eyebrow">
                        @include('partials.icon', ['d' => $promo['icon'], 'class' => 'icon icon--small', 'stroke' => 2])
                        {{ $promo['eyebrow'] }}
                    </p>
                    <h3 class="promo-banner__title">{{ $promo['title'] }}</h3>
                    <ul class="promo-banner__points">
                        @foreach ($promo['points'] as $point)
                            <li class="promo-banner__point">
                                @include('partials.icon', ['d' => 'm5 12 5 5 9-10', 'class' => 'icon icon--small promo-banner__check', 'stroke' => 2.5])
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="{{ $promo['href'] }}" class="button button--primary promo-banner__cta" @isset($promo['category'])
                data-set-category="{{ $promo['category'] }}" @endisset>
                    {{ $promo['cta'] }}
                    <span aria-hidden="true" class="button__arrow">→</span>
                </a>
            </article>
        @endforeach
    </div>
</section>