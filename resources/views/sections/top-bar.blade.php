<div class="top-bar">
    <div class="top-bar__clip">
        <div class="top-bar__inner">
            <p class="top-bar__message">Spedizioni gratuite per gli ordini online</p>
            <ul class="top-bar__links">
                @foreach (config('catalog.utility_links') as $link)
                    <li><a href="#inizio" class="top-bar__link">{{ $link }}</a></li>
                @endforeach
                <li class="dropdown" data-dropdown>
                    <button type="button" class="top-bar__link dropdown__toggle" aria-expanded="false"
                        aria-controls="menu-piattaforma">
                        {{ config('catalog.platform_label') }}
                        @include('partials.icon', ['d' => 'm6 9 6 6 6-6', 'class' => 'dropdown__chevron', 'stroke' => 2])
                    </button>
                    <div id="menu-piattaforma" class="dropdown__panel" hidden>
                        <ul class="dropdown__list">
                            @foreach (config('catalog.platform_items') as $item)
                                <li><button type="button" class="dropdown__item" data-dropdown-close>{{ $item }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>