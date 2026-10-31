@extends('layouts.app')

@section('title', 'Contatti · Giunti Psychometrics')
@section('description', "Hai una domanda su un test, un corso o un ordine? Contatta l'assistenza clienti: ti risponderemo il prima possibile.")

@section('content')
<main id="contenuto" class="contact-page">
    @include('partials.breadcrumb', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Contatti']]])

    <header class="contact-page__header">
        <h1 class="contact-page__title">Contattaci</h1>
        <p class="contact-page__lead">
            Hai una domanda su un test, un corso o un ordine? Scrivici: ti risponderemo il prima possibile.
        </p>
    </header>

    <div class="contact-page__layout">
        <section class="contact-page__channels" aria-labelledby="canali-titolo">
            <h2 id="canali-titolo" class="sr-only">Canali di contatto</h2>
            @foreach (config('catalog.contact_channels') as $channel)
                <article class="contact-card contact-card--hoverable">
                    <h3 class="contact-card__title">{{ $channel['title'] }}</h3>
                    <p class="contact-card__description">{{ $channel['description'] }}</p>
                    <ul class="contact-card__list">
                        <li class="contact-card__item">
                            @include('partials.icon', ['d' => 'M4 6h16v12H4zM4 7l8 6 8-6', 'class' => 'icon contact-card__icon'])
                            <a href="mailto:{{ $channel['email'] }}" class="link">{{ $channel['email'] }}</a>
                        </li>
                        @isset($channel['phone'])
                            <li class="contact-card__item">
                                @include('partials.icon', ['d' => 'M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z', 'class' => 'icon contact-card__icon'])
                                <a href="tel:{{ str_replace(' ', '', $channel['phone']) }}"
                                    class="link">{{ $channel['phone'] }}</a>
                            </li>
                        @endisset
                        <li class="contact-card__item contact-card__item--muted">
                            @include('partials.icon', ['d' => 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM12 7v5l3 2', 'class' => 'icon contact-card__icon'])
                            {{ $channel['hours'] }}
                        </li>
                    </ul>
                </article>
            @endforeach

            @php($hq = config('catalog.headquarters'))
            <article class="contact-card">
                <h3 class="contact-card__title">{{ $hq['name'] }}</h3>
                <address class="contact-card__address">
                    @include('partials.icon', ['d' => 'M12 21s7-6.2 7-11a7 7 0 0 0-14 0c0 4.8 7 11 7 11zM12 7.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z', 'class' => 'icon contact-card__icon'])
                    <span>
                        @foreach ($hq['lines'] as $line)
                            <span class="contact-card__line">{{ $line }}</span>
                        @endforeach
                    </span>
                </address>
                <p class="contact-card__note">Dati dimostrativi: indirizzi, telefoni ed email non sono reali.</p>
            </article>
        </section>

        <section class="contact-page__form" aria-labelledby="modulo-titolo">
            <h2 id="modulo-titolo" class="contact-page__form-title">Scrivici un messaggio</h2>
            @include('partials.contact-form')
        </section>
    </div>

    <section id="faq" class="faq" aria-labelledby="faq-titolo">
        <h2 id="faq-titolo" class="faq__title">Domande frequenti</h2>
        <div class="faq__list">
            @foreach (config('catalog.faqs') as $faq)
                <details class="faq__item" @if ($loop->first) open @endif>
                    <summary class="faq__question">
                        {{ $faq['question'] }}
                        <span aria-hidden="true" class="faq__chevron">⌄</span>
                    </summary>
                    <p class="faq__answer">{{ $faq['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </section>

    <section class="contact-cta" aria-labelledby="cta-titolo">
        <h2 id="cta-titolo" class="contact-cta__title">Cerchi un test o un corso?</h2>
        <p class="contact-cta__text">Sfoglia il catalogo e filtra per categoria, formato e prezzo.</p>
        <a href="/#catalogo" class="button button--accent contact-cta__button">Esplora il catalogo</a>
    </section>
</main>
@endsection