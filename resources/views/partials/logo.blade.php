@php($variant = $variant ?? 'header')
<a href="/" class="logo logo--{{ $variant }}" aria-label="Giunti Psychometrics, vai alla home">
    <svg aria-hidden="true" viewBox="0 0 40 40" class="logo__mark">
        <path d="M6 20 22 4h12L18 20z" fill="{{ $variant === 'footer' ? '#ffffff' : '#1B4F8A' }}" />
        <path d="M6 36 22 20h12L18 36z" fill="#0EA5E9" />
    </svg>
    <span class="logo__text">Giunti<br>Psychometrics</span>
</a>