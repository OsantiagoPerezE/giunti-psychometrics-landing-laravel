<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Giunti Psychometrics · Catalogo test e corsi')</title>
    <meta name="description"
        content="@yield('description', 'Catalogo di test psicologici e corsi di formazione per professionisti di Giunti Psychometrics Italia.')">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preload" href="/fonts/geist-latin.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('head')
</head>

<body class="page">
    <a href="#contenuto" class="skip-link">Vai al contenuto</a>
    <div id="inizio"></div>

    <div class="sticky-chrome__spacer" aria-hidden="true"></div>
    <div class="sticky-chrome" data-sticky-chrome>
        @include('sections.top-bar')
        @include('sections.header')
    </div>

    @yield('content')

    @include('partials.search-modal')

    @include('sections.footer')

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>