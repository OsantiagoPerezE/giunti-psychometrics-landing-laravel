@php($contact = config('catalog.contact'))

<footer class="footer">
    <div class="footer__newsletter">
        <div class="footer__newsletter-inner">
            <div>
                <h2 class="footer__heading">Resta aggiornato</h2>
                <p class="footer__muted">Ricevi novità su nuovi test, formazione ed eventi direttamente nella tua
                    casella email.</p>
            </div>
            <div class="footer__newsletter-form">
                @include('partials.newsletter-form')
            </div>
        </div>
    </div>

    <div class="footer__main">
        <div class="footer__brand">
            @include('partials.logo', ['variant' => 'footer'])
            <p class="footer__muted footer__tagline">
                Test, formazione e risorse per la valutazione psicologica in ambito clinico, scolastico e lavorativo.
            </p>
            <address class="footer__address">
                <p><a href="mailto:{{ $contact['email'] }}" class="footer__link">{{ $contact['email'] }}</a></p>
                <p>
                    <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                        class="footer__link">{{ $contact['phone'] }}</a>
                    · {{ $contact['hours'] }}
                </p>
                <p>{{ $contact['address'] }}</p>
            </address>
        </div>

        @foreach (config('catalog.footer_columns') as $column)
            <nav class="footer__column" aria-label="{{ $column['title'] }}">
                <h2 class="footer__column-title">{{ $column['title'] }}</h2>
                <ul class="footer__column-list">
                    @foreach ($column['links'] as $link)
                        <li><a href="{{ $link['href'] }}" class="footer__link footer__link--nav" @isset($link['category'])
                        data-set-category="{{ $link['category'] }}" @endisset>{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
        @endforeach
    </div>

    <div class="footer__bottom">
        <div class="footer__bottom-inner">
            <div class="footer__legal">
                <p>© {{ date('Y') }} Giunti Psychometrics. Progetto dimostrativo con dati fittizi: nomi, prezzi e
                    contenuti non sono reali.</p>
                <ul class="footer__legal-list" aria-label="Informazioni legali">
                    @foreach (config('catalog.footer_legal') as $link)
                        <li><a href="{{ $link['href'] }}" class="footer__link">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer__end">
                <ul class="footer__social" aria-label="Social network">
                    @foreach (config('catalog.social') as $social)
                        <li>
                            <a href="{{ $social['href'] }}" class="footer__social-link" aria-label="{{ $social['label'] }}">
                                @include('partials.social-icon', ['id' => $social['id']])
                            </a>
                        </li>
                    @endforeach
                </ul>
                <a href="#inizio" class="footer__top">Torna su <span aria-hidden="true">↑</span></a>
            </div>
        </div>
    </div>
</footer>