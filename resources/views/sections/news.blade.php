<section id="risorse" class="news section" aria-labelledby="notizie-titolo">
    <h2 id="notizie-titolo" class="section__title">Notizie e approfondimenti</h2>
    <ul class="news__grid">
        @foreach (config('catalog.news') as $article)
            <li>
                <article class="news-card">
                    <div class="news-card__media">
                        <img src="{{ $article['image'] }}" alt="{{ $article['alt'] }}" class="news-card__image"
                            loading="lazy">
                    </div>
                    <div class="news-card__body">
                        <h3 class="news-card__title">{{ $article['title'] }}</h3>
                        <p class="news-card__excerpt">{{ $article['excerpt'] }}</p>
                    </div>
                </article>
            </li>
        @endforeach
    </ul>
</section>