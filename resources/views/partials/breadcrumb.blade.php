<nav aria-label="Breadcrumb" class="breadcrumb">
    <ol class="breadcrumb__list">
        @foreach ($items as $item)
            <li class="breadcrumb__item">
                @if ($loop->last)
                    <span aria-current="page" class="breadcrumb__current">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['href'] }}" class="breadcrumb__link">{{ $item['label'] }}</a>
                    <span aria-hidden="true" class="breadcrumb__separator">/</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>