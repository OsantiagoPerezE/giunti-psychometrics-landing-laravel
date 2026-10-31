<header class="header">
    <div class="header__inner">
        @include('partials.logo')

        <nav id="menu-principale" class="header__nav" aria-label="Navigazione principale">
            <ul class="header__nav-list">
                <li>
                    <button type="button" class="header__nav-link header__mega-toggle" aria-expanded="false"
                        aria-controls="menu-test" data-nav-section="catalogo" data-mega-toggle>
                        Test
                        @include('partials.icon', ['d' => 'm6 9 6 6 6-6', 'class' => 'header__mega-chevron', 'stroke' => 2.2])
                    </button>
                </li>
                @foreach (config('catalog.nav') as $item)
                    <li>
                        <a href="{{ $item['href'] }}" class="header__nav-link" @isset($item['section'])
                        data-nav-section="{{ $item['section'] }}" @endisset @if (isset($item['page']) && request()->is($item['page'])) aria-current="page" @endif @isset($item['category'])
                            data-set-category="{{ $item['category'] }}" @endisset>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
                <li class="header__nav-mobile-only header__nav-mobile-only--md">
                    <button type="button" class="button button--soft button--block header__nav-login">Accedi</button>
                </li>
                <li class="header__nav-mobile-only header__nav-extra">
                    <ul class="header__nav-extra-list">
                        @foreach ([...config('catalog.utility_links'), config('catalog.platform_label')] as $link)
                            <li><a href="#inizio" class="header__nav-extra-link">{{ $link }}</a></li>
                        @endforeach
                        @foreach (config('catalog.platform_items') as $link)
                            <li><a href="#inizio" class="header__nav-extra-link header__nav-extra-link--sub">{{ $link }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="header__actions">
            <div class="dropdown quick-links" data-dropdown>
                <button type="button" class="quick-links__toggle dropdown__toggle" aria-label="Collegamenti rapidi"
                    title="Collegamenti rapidi" aria-expanded="false" aria-controls="menu-collegamenti">
                    <svg aria-hidden="true" viewBox="0 0 24 24" class="icon-button__icon" fill="currentColor">
                        @foreach ([6, 12, 18] as $x)
                            @foreach ([6, 12, 18] as $y)
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="1.7" />
                            @endforeach
                        @endforeach
                    </svg>
                </button>
                <div id="menu-collegamenti" class="dropdown__panel" hidden>
                    <div class="dropdown__list">
                        <ul>
                            @foreach (config('catalog.utility_links') as $link)
                                <li><button type="button" class="dropdown__item" data-dropdown-close>{{ $link }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <p class="quick-links__label">{{ config('catalog.platform_label') }}</p>
                        <ul>
                            @foreach (config('catalog.platform_items') as $item)
                                <li><button type="button" class="dropdown__item" data-dropdown-close>{{ $item }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <button type="button" class="button button--soft header__login">Accedi</button>

            <button type="button" class="icon-button" aria-label="Cerca un prodotto" aria-haspopup="dialog"
                aria-controls="ricerca-modal" data-open-search>
                @include('partials.icon', ['d' => 'M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM20 20l-3.5-3.5', 'class' => 'icon-button__icon'])
            </button>

            <button type="button" class="icon-button" aria-label="Carrello, 0 articoli">
                <svg aria-hidden="true" viewBox="0 0 24 24" class="icon-button__icon" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 4h2l2.4 11h10.2L20 7H6.2" />
                    <circle cx="9" cy="19" r="1.4" />
                    <circle cx="17" cy="19" r="1.4" />
                </svg>
            </button>

            <button type="button" class="icon-button header__menu-toggle" aria-expanded="false"
                aria-controls="menu-principale" aria-label="Apri il menu" data-menu-toggle>
                <svg aria-hidden="true" viewBox="0 0 24 24" class="icon-button__icon" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round">
                    <path class="header__menu-open" d="M4 7h16M4 12h16M4 17h16" />
                    <path class="header__menu-close" d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div class="header__progress" aria-hidden="true"></div>

    <div id="menu-test" class="mega-menu" data-mega-menu hidden>
        <div class="mega-menu__inner">
            <div class="mega-menu__actions">
                <a href="/#catalogo" class="button button--outline" data-show-all>Scopri tutti i test</a>
                <a href="/#catalogo" class="button button--outline" data-mega-link>Test e corsi in evidenza</a>
                <button type="button" class="mega-menu__close" data-mega-close>Chiudi</button>
            </div>

            <div class="mega-menu__columns">
                @foreach ([
                        ['title' => 'Ambito', 'attr' => 'data-set-category', 'param' => 'categoria', 'items' => collect(config('catalog.categories'))->map(fn($c) => ['slug' => $c['id'], 'label' => $c['label']])],
                        ['title' => 'Temi', 'attr' => 'data-set-topic', 'param' => 'tema', 'items' => config('catalog.temi'), 'wide' => true],
                        ['title' => 'Costrutti', 'attr' => 'data-set-construct', 'param' => 'costrutto', 'items' => config('catalog.costrutti'), 'wide' => true],
                    ] as $column)
                    <div class="mega-menu__column">
                        <p class="mega-menu__title">{{ $column['title'] }}</p>
                        <ul class="mega-menu__list {{ empty($column['wide']) ? '' : 'mega-menu__list--two-cols' }}">
                            @foreach ($column['items'] as $item)
                                <li>
                                    <a href="/?{{ $column['param'] }}={{ $item['slug'] }}#catalogo" class="mega-menu__link" {{ $column['attr'] }}="{{ $item['slug'] }}" data-mega-link>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</header>