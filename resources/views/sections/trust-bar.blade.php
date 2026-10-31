<section class="trust-bar" aria-label="I nostri vantaggi">
    <ul class="trust-bar__list">
        @foreach (config('catalog.trust') as $item)
            <li class="trust-bar__item">
                @include('partials.icon', ['d' => $item['icon'], 'class' => 'trust-bar__icon', 'stroke' => 1.6])
                <span class="trust-bar__label">{{ $item['label'] }}</span>
            </li>
        @endforeach
    </ul>
</section>