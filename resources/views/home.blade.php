@extends('layouts.app')

@section('content')
    <main id="contenuto">
        @include('sections.hero')
        @include('sections.catalog')
        @include('sections.promo-banners')
        @include('sections.photo-banner')
        @include('sections.mission')
        @include('sections.news')
        @include('sections.help')
    </main>
    @include('sections.trust-bar')

    @include('partials.filters-modal')
@endsection